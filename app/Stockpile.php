<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stockpile extends Model
{
    const CREATED_AT = 'entry_date';
    const UPDATED_AT = 'sync_date';
    
    protected $table = "stockpile";
    protected $primaryKey = 'stockpile_id';
    protected $fillable = [
        'stockpile_code',
        'stockpile_address',
        'stockpile_link',
        'latitude',
        'longitude',
        'url_cctv',
        'updated_by'
    ];
    protected $appends = ['pks_response'];
    
    public function getProgressAttribute()
    {
        $categories = CategoryDocument::where('category_for', 1)->get();
        $totalCategories = count($categories);

        $totalDocument = $totalCategories * $this->total_supplier;

        if($this->total_document != 0){
            return number_format($this->total_document / $totalDocument * 100,2).'%';
        }
        return '0%';

    }
    public function getTotalDocumentAttribute()
    {
        $q = DB::select("SELECT (SELECT count(vendor_id) FROM master_document WHERE vendor_id = c.vendor_id) as totalDoc FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN master_document as md ON md.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        GROUP BY c.vendor_id");
        $sum = 0;
        foreach ($q as $val) {
            $sum += $val->totalDoc;
        }
        return $sum;
    }
    
    public function getPKSNotFollowedUpAttribute()
    {
        return $this->total_supplier - $this->pks_followed_up;
    }

    public function getPksFollowedUpAttribute(){
        $q = DB::select("SELECT fud.vendor_id as id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN  follow_up_document as fud ON fud.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        GROUP BY fud.vendor_id");
        $total = isset($q) ? count($q) : 0;
        return $total;
    }
    public function getPksResponseAttribute(){
        $q = DB::select("SELECT md.vendor_id as id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN  master_document as md ON md.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        GROUP BY c.vendor_id");
        $total = isset($q) ? count($q) : 0;
        return $total;
    }
    
    public function getTotalSupplierAttribute()
    {
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
