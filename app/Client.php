<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Client extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nombre', 
        'cedula', 
        'telefono_referencia', 
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

}
