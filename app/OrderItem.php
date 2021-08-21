<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'precio',
        'suplidor',
        'nombre',
        'cantidad',
        'tipo',
        'key_id',
        'deleted_at',
        'created_at'
    ];
}
