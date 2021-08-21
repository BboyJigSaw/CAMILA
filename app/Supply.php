<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supply extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'suplidor',
        'supplier_id', 
        'modelo',
        'comentario',
        'activo',
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

}
