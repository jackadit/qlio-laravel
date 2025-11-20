<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwPays extends Model
{
    protected $table = 'sw_pays';
    
    protected $primaryKey = 'pays_id';
    
    public $timestamps = false;
    
    protected $fillable = [
        'pays_nom',
        'pays_code',
        'pays_alpha2',
        'pays_alpha3'
    ];
}
