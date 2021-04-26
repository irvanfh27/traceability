<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StockpileContract extends Model
{
    protected $table = 'stockpile_contract';
    protected $primaryKey = 'stockpile_contract_id';

    protected $appends = ['total_supplier'];

    public function getTotalSupplierAttribute(){
        return $this->contract->count();
    }

    public function getVendorNameAttribute()
    {
        return $this->contract->vendor_name;
    }

    public function getTotalDocumentVendorAttribute()
    {
        return $this->contract->document_total;
    }

    /**
     * Get the transaction that owns the StockpileContract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'stockpile_contract_id', 'stockpile_contract_id');
    }

    /**
     * Get the stockpile that owns the StockpileContract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stockpile()
    {
        return $this->belongsTo(Stockpile::class, 'stockpile_id', 'stockpile_id');
    }

    /**
     * Get the contract that owns the StockpileContract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'contract_id');
    }

}
