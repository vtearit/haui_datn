<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    public $timestamps = false;

    protected $table = 'coupon';
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
