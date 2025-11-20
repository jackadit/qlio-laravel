<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwSoc extends Model
{
    protected $table = 'sw_soc';
    
    protected $primaryKey = 'soc_id';
    
    public $timestamps = false;
    
    protected $fillable = [
        'createur_id',
        'soc_typsoc_id',
        'soc_pays_id',
        'soc_repres_id',
        'soc_typliv_id',
        'soc_typlan_id',
        'soc_typval_id',
        'soc_typreg_id',
        'soc_typpay_id',
        'soc_typsect_id',
        'soc_profil_id',
        'soc_num',
        'soc_nom',
        'soc_adresse',
        'soc_adressebis',
        'soc_bp',
        'soc_cp',
        'soc_commune',
        'soc_tel',
        'soc_fax',
        'soc_mel',
        'soc_web',
        'soc_siret',
        'soc_tva',
        'soc_naf',
        'soc_iban',
        'soc_bic',
        'soc_credit',
        'soc_obs',
        'soc_lat',
        'soc_lng',
        'soc_defaut',
        'ctime',
        'utime',
        'actif',
        'lock',
        'prospect'
    ];
    
    protected $casts = [
        'soc_defaut' => 'boolean',
        'actif' => 'boolean',
        'lock' => 'boolean',
        'prospect' => 'boolean',
        'soc_lat' => 'decimal:6',
        'soc_lng' => 'decimal:6',
        'soc_credit' => 'integer',
        'ctime' => 'datetime',
        'utime' => 'datetime'
    ];
    
    public function pays()
    {
        return $this->belongsTo(SwPays::class, 'soc_pays_id', 'pays_id');
    }
    
    public function getFormattedTelAttribute()
    {
        $tel = $this->soc_tel;
        if (empty($tel)) {
            return '';
        }
        
        // Supprimer tous les caractères non numériques
        $tel = preg_replace('/[^0-9]/', '', $tel);
        
        // Vérifier si on a 10 chiffres
        if (strlen($tel) === 10) {
            return substr($tel, 0, 2) . ' ' . substr($tel, 2, 2) . ' ' . substr($tel, 4, 2) . ' ' . substr($tel, 6, 2) . ' ' . substr($tel, 8, 2);
        }
        
        return $tel;
    }
    
    public function getFormattedFaxAttribute()
    {
        $fax = $this->soc_fax;
        if (empty($fax)) {
            return '';
        }
        
        // Supprimer tous les caractères non numériques
        $fax = preg_replace('/[^0-9]/', '', $fax);
        
        // Vérifier si on a 10 chiffres
        if (strlen($fax) === 10) {
            return substr($fax, 0, 2) . ' ' . substr($fax, 2, 2) . ' ' . substr($fax, 4, 2) . ' ' . substr($fax, 6, 2) . ' ' . substr($fax, 8, 2);
        }
        
        return $fax;
    }
    
    // Relations avec les stages
    public function stages()
    {
        return $this->hasMany(SwStage::class, 'sta_soc_id', 'soc_id');
    }
    
    public function stagesActifs()
    {
        return $this->stages()->where('actif', true);
    }
    
    public function stagesEnCours()
    {
        return $this->stages()->actifs()->enCours();
    }
    
    public function tuteursSoc()
    {
        return $this->hasMany(SwUser::class, 'user_id', 'user_id')
                    ->where('user_role', 'tuteur_soc');
    }
    
    // Accesseurs
    public function getNbStagesAttribute()
    {
        return $this->stages()->count();
    }
    
    public function getNbStagesActifsAttribute()
    {
        return $this->stagesActifs()->count();
    }
    
    public function getNbStagesEnCoursAttribute()
    {
        return $this->stagesEnCours()->count();
    }
}
