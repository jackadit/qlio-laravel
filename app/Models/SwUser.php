<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class SwUser extends Authenticatable
{
    protected $table = 'sw_user';
    
    protected $primaryKey = 'user_id';
    
    public $timestamps = false;
    
    protected $fillable = [
        'createur_id',
        'user_vue_id',
        'user_type_id',
        'user_num',
        'user_civilite',
        'user_nom',
        'user_prenom',
        'user_login',
        'user_tel',
        'user_tel_port',
        'user_mel',
        'user_fax',
        'user_adresse',
        'user_adresse_bis',
        'user_cp',
        'user_commune',
        'user_bp',
        'user_pass',
        'user_pass_hash',
        'user_cb_mode',
        'user_cb_multi',
        'user_cb_redir',
        'user_cb_force_mdp',
        'ctime',
        'utime',
        'actif'
    ];
    
    protected $hidden = [
        'user_pass',
        'user_pass_hash'
    ];
    
    protected $casts = [
        'actif' => 'boolean',
        'ctime' => 'datetime',
        'utime' => 'timestamp',
        'user_civilite' => 'integer',
        'user_type_id' => 'integer',
        'user_cb_mode' => 'integer',
        'user_cb_multi' => 'integer',
        'user_cb_redir' => 'integer',
        'user_cb_force_mdp' => 'integer'
    ];
    
    // Relations avec les stages
    public function stagesAsTuteurPeda()
    {
        return $this->hasMany(SwStage::class, 'sta_tutpeda_id', 'user_id');
    }
    
    public function stagesAsTuteurSoc()
    {
        return $this->hasMany(SwStage::class, 'sta_tutsoc_id', 'user_id');
    }
    
    public function stagesAsEtudiant()
    {
        return $this->hasMany(SwStage::class, 'sta_etu_id', 'user_id');
    }
    
    public function stagesCreated()
    {
        return $this->hasMany(SwStage::class, 'createur_id', 'user_id');
    }
    
    // Accessors
    public function getFullNameAttribute()
    {
        return $this->user_prenom . ' ' . $this->user_nom;
    }
    
    public function getFormattedTelephoneAttribute()
    {
        $tel = $this->user_tel;
        if (empty($tel)) {
            return '';
        }
        
        // Formatage du téléphone français
        $tel = preg_replace('/[^0-9]/', '', $tel);
        if (strlen($tel) === 10) {
            return substr($tel, 0, 2) . ' ' . substr($tel, 2, 2) . ' ' . substr($tel, 4, 2) . ' ' . substr($tel, 6, 2) . ' ' . substr($tel, 8, 2);
        }
        
        return $tel;
    }
    
    public function getTelephoneAttribute()
    {
        return $this->user_tel;
    }
    
    public function getEmailAttribute()
    {
        return $this->user_mel;
    }
    
    public function getRoleAttribute()
    {
        $roles = [
            1 => 'etudiant',
            2 => 'tuteur',
            3 => 'tuteur_soc',
            4 => 'admin',
            5 => 'entreprise'
        ];
        
        return $roles[$this->user_type_id] ?? 'inconnu';
    }
    
    public function getRoleBadgeAttribute()
    {
        $colors = [
            1 => 'orange', // étudiant
            2 => 'blue',   // tuteur
            3 => 'green',  // tuteur_soc
            4 => 'purple', // admin
            5 => 'gray'    // entreprise
        ];
        
        $role = $this->role;
        $color = $colors[$this->user_type_id] ?? 'gray';
        
        return "<span class='px-2 py-1 text-xs rounded-full bg-{$color}-100 text-{$color}-800'>{$role}</span>";
    }
    
    // Scopes pour les différents types d'utilisateurs
    public function scopeEtudiants($query)
    {
        return $query->where('user_type_id', 1); // Supposition : 1 = étudiant
    }
    
    public function scopeTuteurs($query)
    {
        return $query->whereIn('user_type_id', [2, 3]); // Supposition : 2 = tuteur, 3 = tuteur entreprise
    }
    
    public function scopeAdmins($query)
    {
        return $query->where('user_type_id', 4); // Supposition : 4 = admin
    }
    
    public function scopeActifs($query)
    {
        return $query->where('actif', 1);
    }

    public function groupes()
    {
        return $this->belongsToMany(SwGroupe::class, 'sw_l_user_groupe', 'user_id', 'groupe_id');
    }

    public function droits()
    {
        return $this->hasMany(SwDroit::class, 'target_id', 'user_id')->where('target_type', 'user');
    }

    public function getAuthPassword()
    {
        return $this->user_pass_hash;
    }
}
