<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = "wilayah_provinsi";

    /**
     * Get all of the districts for the Province
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany(Districts::class,'id','provinsi_id');
    }
}
