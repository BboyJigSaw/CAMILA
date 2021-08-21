<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Supplier extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'empresa',
        'telefono',
        'correo',
        'enlace',
        'comentario',
        'activo',
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

}
