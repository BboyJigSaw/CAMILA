<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'client_id',
        'status_id',
        'monto_total',
        'key_id',
        'created_by',
        'updated_by',
        'updated_at',
        'deleted_at'
    ];

    public function status()
    {
        return $this->belongsTo('App\Status');
    }

    public function client()
    {
        return $this->belongsTo('App\Client');
    }

    public function items()
    {
        return $this->hasMany('App\OrderItem');
    }

}
