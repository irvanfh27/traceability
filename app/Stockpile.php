<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stockpile extends Model
{
    protected $table = "stockpile";
    protected $primaryKey = 'stockpile_id';
    protected $fillable = [
        'stockpile_id',
        'stockpile_code',
        'stockpile_name',
        'stockpile_address',
        'stockpile_link',
        'latitude',
        'longitude'
    ];

    public function getTotalSupplierAttribute(){
        $q = DB::select("SELECT COUNT(*) as total FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        GROUP BY c.vendor_id");
        $total = count($q);

        return $total;
    }

    public function supplier()
    {
       return $this->hasMany(Vendor::class, 'stockpile_id', 'stockpile_id');
    }

    /**
     * Get all of the stockpileContract for the Stockpile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stockpileContract()
    {
        return $this->hasMany(StockpileContract::class, 'stockpile_id', 'stockpile_id');
    }
}
