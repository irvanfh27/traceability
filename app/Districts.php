<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    protected $table = "wilayah_kabupaten";

    public function getProvinceNameAttribute()
    {
        return $this->province->nama;
    }
    /**
     * Get the province that owns the Districts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function province()
    {
        return $this->belongsTo(Province::class, 'provinsi_id');
    }
}
