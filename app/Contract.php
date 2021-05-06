<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contract';
    protected $primaryKey = 'contract_id';


    public function getStockpileNameAttribute()
    {
        return $this->stockpileContract->stockpile_name;
    }

    public function getVendorNameAttribute()
    {
        return $this->vendor->vendor_name;
    }

    public function getTotalDocumentVendorAttribute()
    {
        return $this->vendor->document_total;
    }

    /**
     * Get the stockpile that owns the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stockpileContract()
    {
        return $this->belongsTo(StockpileContract::class, 'contract_id', 'contract_id');
    }
    /**
     * Get the vendor that owns the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'vendor_id');
    }
}
