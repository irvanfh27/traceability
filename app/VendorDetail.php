<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorDetail extends Model
{
    protected $table = 'vendor_detail';

    protected $fillable = [
        'vendor_id','link_maps','latitude','longitude','districts','province','pic_name','no_telp_office','no_telp_hp','link_website','email',
        'kapasitas_produksi'
    ];
}
