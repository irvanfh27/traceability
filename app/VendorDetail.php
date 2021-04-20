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

    public function getDistrictNameAttribute()
    {
        return isset($this->district->nama) ? $this->district->nama : "";
    }

    public function getProvinceNameAttribute()
    {
        return isset($this->district->province_name) ? $this->district->province_name : "";
    }
     /**
    * Get the district that owns the Vendor
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function district()
    {
        return $this->belongsTo(Districts::class, 'districts', 'id');
    }
}
