<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PhoneInventory extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supply_id',    
        'nombre',
        'cantidad_existencia',
        'costo_total', 
        'activo', 
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

    public function supply()
    {
        return $this->belongsTo('App\Supply');
    }

    public function inventoryDetail()
    {
        return $this->hasMany('App\PhoneInventoryDetail');
    }
}
