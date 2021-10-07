<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeShip extends Model
{
    use HasFactory;
    protected $table = "feeship";
    public $timestamps = false;
    public function xa()
    {
        return $this->belongsTo('App\Models\Ward', 'fee_xaid', 'xaid');
    }
    public function qh()
    {
        return $this->belongsTo('App\Models\District', 'fee_maqh', 'maqh');
    }
    public function tp()
    {
        return $this->belongsTo('App\Models\Province', 'fee_matp', 'matp');
    }
}
