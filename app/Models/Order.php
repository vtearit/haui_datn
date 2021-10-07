<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    use HasFactory;
    protected $table = 'order';
    public function orderDetails()
    {
        return $this->hasMany('App\Models\OrderDetail', 'order_id', 'id');
    }
    public function shipping()
    {
        return $this->hasOne('App\Models\Shipping', 'id', 'shipping_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
