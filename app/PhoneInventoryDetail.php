<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhoneInventoryDetail extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone_inventory_id',   
        'imei',       
        'tipo',
        'cantidad',
        'costo',
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

    public function inventory()
    {
        return $this->belongsTo('App\Inventory');
    }
}
