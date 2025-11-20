<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwStage extends Model
{
    protected $table = 'sw_sta';
    
    protected $primaryKey = 'sta_id';
    
    public $timestamps = false;
    
    protected $fillable = [
        'createur_id',
        'sta_tutpeda_id',
        'sta_tutsoc_id',
        'sta_soc_id',
        'sta_etu_id',
        'sta_typsta_id',
        'sta_nom',
        'sta_obs',
        'sta_debut',
        'sta_fin',
        'ctime',
        'utime',
        'actif'
    ];
    
    protected $casts = [
        'sta_debut' => 'datetime',
        'sta_fin' => 'datetime',
        'ctime' => 'datetime',
        'utime' => 'datetime',
        'actif' => 'boolean'
    ];
    
    protected static function boot()
    {
        parent::boot();
        
        // Définir une valeur par défaut pour sta_typsta_id lors de la création
        static::creating(function ($stage) {
            if (is_null($stage->sta_typsta_id)) {
                try {
                    // Mettre la valeur par défaut au premier type de stage actif
                    $defaultType = \App\Models\SwTypeStage::where('actif', 1)->first();
                    if ($defaultType) {
                        $stage->sta_typsta_id = $defaultType->typsta_id;
                    }
                } catch (\Exception $e) {
                    // Si la table n'existe pas, on ne fait rien
                    // Le champ restera null et la migration devra être exécutée
                }
            }
        });
    }
    
    // Relations
    public function createur()
    {
        return $this->belongsTo(SwUser::class, 'createur_id', 'user_id');
    }
    
    public function tuteurPeda()
    {
        return $this->belongsTo(SwUser::class, 'sta_tutpeda_id', 'user_id');
    }
    
    public function tuteurSoc()
    {
        return $this->belongsTo(SwUser::class, 'sta_tutsoc_id', 'user_id');
    }
    
    public function etudiant()
    {
        return $this->belongsTo(SwUser::class, 'sta_etu_id', 'user_id');
    }
    
    public function societe()
    {
        return $this->belongsTo(SwSoc::class, 'sta_soc_id', 'soc_id');
    }
    
    public function typeStage()
    {
        return $this->belongsTo(SwTypeStage::class, 'sta_typsta_id', 'typsta_id');
    }
    
    // Accesseurs
    public function getDureeAttribute()
    {
        if (!$this->sta_debut || !$this->sta_fin) {
            return null;
        }
        
        return $this->sta_debut->diffInDays($this->sta_fin) + 1;
    }
    
    public function getDureeFormateeAttribute()
    {
        $duree = $this->getDureeAttribute();
        
        if ($duree === null) {
            return 'Non définie';
        }
        
        if ($duree === 1) {
            return '1 jour';
        }
        
        return $duree . ' jours';
    }
    
    public function getPeriodeFormateeAttribute()
    {
        if (!$this->sta_debut || !$this->sta_fin) {
            return 'Non définie';
        }
        
        return $this->sta_debut->format('d/m/Y') . ' au ' . $this->sta_fin->format('d/m/Y');
    }
    
    public function getStatutAttribute()
    {
        if (!$this->actif) {
            return 'Terminé';
        }
        
        if (!$this->sta_debut || !$this->sta_fin) {
            return 'Non défini';
        }
        
        $today = now();
        
        if ($today->lt($this->sta_debut)) {
            return 'À venir';
        }
        
        if ($today->between($this->sta_debut, $this->sta_fin)) {
            return 'En cours';
        }
        
        return 'Terminé';
    }
    
    public function getStatutColorAttribute()
    {
        $statut = $this->getStatutAttribute();
        
        $colors = [
            'À venir' => 'blue',
            'En cours' => 'green',
            'Terminé' => 'gray',
            'Non défini' => 'orange'
        ];
        
        return $colors[$statut] ?? 'gray';
    }
    
    // Scopes
    public function scopeActifs($query)
    {
        return $query->where('actif', true);
    }
    
    public function scopeEnCours($query)
    {
        $today = now();
        return $query->where('actif', true)
                     ->where('sta_debut', '<=', $today)
                     ->where('sta_fin', '>=', $today);
    }
    
    public function scopeAVenir($query)
    {
        return $query->where('actif', true)
                     ->where('sta_debut', '>', now());
    }
    
    public function scopeTermines($query)
    {
        return $query->where('actif', false)
                     ->orWhere(function($q) {
                         $q->where('actif', true)
                           ->where('sta_fin', '<', now());
                     });
    }
    
    public function scopeBySociete($query, $societeId)
    {
        return $query->where('sta_soc_id', $societeId);
    }
    
    public function scopeByEtudiant($query, $etudiantId)
    {
        return $query->where('sta_etu_id', $etudiantId);
    }
    
    public function scopeByTuteur($query, $tuteurId)
    {
        return $query->where(function($q) use ($tuteurId) {
            $q->where('sta_tutpeda_id', $tuteurId)
              ->orWhere('sta_tutsoc_id', $tuteurId);
        });
    }
}
