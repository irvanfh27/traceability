<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Vendor extends Model
{
    protected $table = "vendor";
    protected $primaryKey = "vendor_id";
    protected $fillable = [
        'vendor_id',
        'vendor_code',
        'vendor_name',
        'stockpile_id',
        'vendor_address',
        'vendor_link',
        'vendor_latitude',
        'vendor_longitude'
    ];

    protected $appends = ['kapasitas_produksi','total_document','percentage_document'];

    public function getCollectionRateAttribute()
    {
        if($this->collection != 0 && $this->kapasitas_produksi != 0){
            $collection =  $this->collection  / 1000;
            $sum =  $collection / $this->kapasitas_produksi  * 100;

        }else{
            $sum = 0;
        }
        return $sum.'%';

    }
    public function getCollectionAttribute()
    {
        $currentYear = now()->year;

        $collection = DB::select("SELECT sum(t.send_weight) as collection FROM vendor v
        LEFT JOIN contract as c ON c.vendor_id = v.vendor_id
        LEFT JOIN stockpile_contract as sc ON sc.contract_id = c.contract_id
        LEFT JOIN transaction as t ON t.stockpile_contract_id = sc.stockpile_contract_id
        WHERE v.vendor_id = $this->vendor_id
        AND DATE_FORMAT(t.entry_date,'%Y') = '$currentYear'
        GROUP BY v.vendor_id");

        $num = isset($collection[0]->collection) ? $collection[0]->collection : 0;

        return $num;

    }
    public function getPercentageDocumentAttribute()
    {
        $totalSupplierDoc = $this->documents->count();
        $totalDoc = CategoryDocument::where('category_for',1)->get()->count();
        $totalPercent = $totalSupplierDoc / $totalDoc * 100;

        return number_format($totalPercent, 2).'%';

    }

    public function getCollectionTonAttribute()
    {
        $collection = $this->collection / 1000;
        return  number_format($collection,2);
    }


    public function getTotalDocumentAttribute()
    {
        return $this->documents->count();
    }

    public function getKapasitasProduksiAttribute()
    {
        return isset($this->detail->kapasitas_produksi) ? $this->detail->kapasitas_produksi : 0;
    }

    public function getKapasitasProduksiTonAttribute()
    {
        $production = isset($this->detail->kapasitas_produksi) ? $this->detail->kapasitas_produksi : 0;

        return number_format($production,2);
    }



    /**
    * Get all documents of the Vendor
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function documents()
    {
        return $this->hasMany(MasterDocument::class, 'vendor_id', 'vendor_id');
    }

    /**
    * Get the document associated with the Vendor
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function latestFollowUp()
    {
        return $this->hasOne(FollowUpDocument::class, 'vendor_id', 'vendor_id')->orderBy('date_follow_up','DESC');
    }

    /**
    * Get the detail that owns the Vendor
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function detail()
    {
        return $this->belongsTo(VendorDetail::class, 'vendor_id', 'vendor_id');
    }

    /**
    * Get all of the followUp for the Vendor
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function followUp()
    {
        return $this->hasMany(FollowUpDocument::class, 'vendor_id', 'vendor_id')->orderBy('date_follow_up','DESC');
    }

    /**
    * Get the contract that owns the Vendor
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'vendor_id', 'vendor_id');
    }

    /**
    * Get all of the contracts for the Vendor
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'vendor_id', 'vendor_id');
    }

}
