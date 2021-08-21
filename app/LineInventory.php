<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LineInventory extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'supply_line_id',    
        'tipo',
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
        return $this->belongsTo('App\PhoneLine');
    }

    public function inventoryDetail()
    {
        return $this->hasMany('App\LineInventoryDetail');
    }
}
