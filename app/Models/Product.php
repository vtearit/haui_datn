<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "product";
    public function groupProduct()
    {
        return $this->belongsTo('App\Models\GroupProduct', 'group_product_id', 'id');
    }
    public function configuration()
    {
        return $this->hasOne('App\Models\Configuration', 'id', 'configuration_id');
    }
}
