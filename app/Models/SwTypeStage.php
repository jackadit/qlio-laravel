<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwTypeStage extends Model
{
    protected $table = 'sw_type_stages';
    protected $primaryKey = 'typsta_id';
    public $timestamps = true;

    protected $fillable = [
        'typsta_libelle',
        'typsta_obs',
        'actif'
    ];

    protected $casts = [
        'actif' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function stages()
    {
        return $this->hasMany(SwStage::class, 'sta_typsta_id', 'typsta_id');
    }
}
