<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwDroit extends Model
{
    protected $table = 'sw_droit';

    protected $primaryKey = 'droit_id';

    public $timestamps = false;

    protected $fillable = [
        'target_type',
        'target_id',
        'module',
        'niveau',
        'createur_id',
        'ctime',
        'utime',
    ];

    protected $casts = [
        'target_id' => 'integer',
        'niveau' => 'integer',
        'ctime' => 'datetime',
        'utime' => 'datetime',
    ];
}
