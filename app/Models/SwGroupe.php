<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwGroupe extends Model
{
    protected $table = 'sw_groupe';

    protected $primaryKey = 'groupe_id';

    public $timestamps = false;

    protected $fillable = [
        'createur_id',
        'groupe_org_id',
        'groupe_nom',
        'groupe_type',
        'ctime',
        'utime',
        'actif',
    ];

    protected $casts = [
        'groupe_type' => 'integer',
        'ctime' => 'datetime',
        'utime' => 'datetime',
        'actif' => 'boolean',
    ];

    public function users()
    {
        return $this->belongsToMany(SwUser::class, 'sw_l_user_groupe', 'groupe_id', 'user_id');
    }

    public function droits()
    {
        return $this->hasMany(SwDroit::class, 'target_id', 'groupe_id')
            ->where('target_type', 'group');
    }
}
