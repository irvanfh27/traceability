<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    protected $table = "shipment";
    protected $primaryKey = 'shipment_id';

    public function sales()
    {
    return $this->belongsTo(Sales::class);
    }
    

}
