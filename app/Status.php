<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Status extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'nombre', 
        'code', 
        'default', 
        'activo', 
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

}
