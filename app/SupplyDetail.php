<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplyDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'supply_id',
        'nombre',
        'suplidor',
        'supplier_id',
        'imei',
        'costo',
        'activo',
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

    public function supply()
    {
        return $this->belongsTo('App\supply');
    }
    
    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }
}
