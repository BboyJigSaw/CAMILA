<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplyLine extends Model
{
    use SoftDeletes;

    protected $table = 'supply_lines';


    protected $fillable = [
        'tipo',
        'suplidor',
        'supplier_id',
        'comentario',
        'activo',
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

    public function supplier()
    {
        return $this->belongsTo('App\Supplier');
    }

}
