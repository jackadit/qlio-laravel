<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwNomenclature extends Model
{
    protected $table = 'sw_nomenclature';

    protected $primaryKey = 'nomenc_id';

    public $timestamps = false;

    protected $fillable = [
        'nomenc_cat',
        'nomenc_nom',
        'nomenc_ref',
        'ordre',
        'actif',
    ];

    protected $casts = [
        'ordre' => 'integer',
        'actif' => 'boolean',
    ];
}
