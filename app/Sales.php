<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $table = "sales";
    protected $primaryKey = 'sales_id';

    public function shipment()
    {
    return $this->hasMany(Shipment::class,'sales_id');
    }

    public function stockpile()
    {
    return $this->hasOne(Stockpile::class,'stockpile_id');
    }
}
