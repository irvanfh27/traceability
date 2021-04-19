<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $table = 'contract';
    protected $primaryKey = 'contract_id';

    /**
     * Get the stockpile that owns the Contract
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stockpileContract()
    {
        return $this->belongsTo(StockpileContract::class, 'contract_id', 'contract_id');
    }
}
