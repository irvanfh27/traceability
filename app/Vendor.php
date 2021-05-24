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

    protected $appends = ['action_button'];

    public function getStockpileNameAttribute()
    {
        return isset($this->contract->stockpile_name) ? $this->contract->stockpile_name : 'NULL';
    }
    /**
     * Status String
     * @return string
     */
    public function getDocumentStatusNameAttribute()
    {
        return isset($this->detail) ? $this->detail->document_status_name : '';
    }

    /**
     * Status INT
     * @return int
     */
    public function getDocumentStatusAttribute()
    {
        return isset($this->detail) ? $this->detail->document_status : 0;
    }

    /**
     * Collection Rate
     * @return string
     */
    public function getCollectionRateAttribute()
    {
        if ($this->collection != 0 && $this->kapasitas_produksi != 0) {
            $collection = $this->collection / 1000;
            $sum = $collection / $this->kapasitas_produksi * 100;

        } else {
            $sum = 0;
        }
        return $sum . '%';

    }

    /**
     * Collection / Year
     * @return int
     */
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

    public function getTotalCatDocSupplierAttribute()
    {
        return CategoryDocument::where('category_for', 1)->get()->count();
    }

    /**
     * Total Document Percent
     * @return string
     */
    public function getPercentageDocumentAttribute()
    {
        $totalSupplierDoc = $this->total_document;
        $totalDoc = $this->TotalCatDocSupplier;
        $totalPercent = $totalSupplierDoc / $totalDoc * 100;

        return number_format($totalPercent, 2) . '%';

    }

    /**
     * Collection Per Ton
     * @return string
     */
    public function getCollectionTonAttribute()
    {
        $collection = $this->collection / 1000;
        return number_format($collection, 2);
    }

    /**
     * Total Document
     * @return mixed
     */
    public function getTotalDocumentAttribute()
    {
        return isset($this->documents) ? $this->documents->whereNotNull('document_no')->whereNotNull('document_date')->count() : 0;
    }

    /**
     * Production Capacity
     * @return int
     */
    public function getKapasitasProduksiAttribute()
    {
        return isset($this->detail->kapasitas_produksi) ? $this->detail->kapasitas_produksi : 0;
    }

    /**
     * Production Capacity Ton
     * @return string
     */
    public function getKapasitasProduksiTonAttribute()
    {
        $production = isset($this->detail->kapasitas_produksi) ? $this->detail->kapasitas_produksi : 0;

        return number_format($production, 2);
    }

    /**
     * District String
     * @return string
     */
    public function getDistrictNameAttribute()
    {
        return isset($this->detail->district_name) ? $this->detail->district_name : "";
    }

    /**
     * Province String
     * @return string
     */
    public function getProvinceNameAttribute()
    {
        return isset($this->detail->province_name) ? $this->detail->province_name : "";
    }

    /**
     * Button Action
     * @return string
     */
    public function getActionButtonAttribute(): string
    {
        return '<a class="btn btn-primary" href="' . route('vendor.show', $this->vendor_id) . '">Detail</a>&nbsp;' .
            '<a class="btn btn-success" href="' . route('vendor.edit', $this->vendor_id) . '">Edit</a>';
    }

    public function getDocumentTotalAttribute()
    {
        // return isset($this->documents) ? $this->documents->count() : 0;
        return isset($this->documents) ? $this->documents->whereNotNull('document_no')->whereNotNull('document_date')->count() : 0;
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
        return $this->hasOne(FollowUpDocument::class, 'vendor_id', 'vendor_id')->orderBy('date_follow_up', 'DESC');
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
        return $this->hasMany(FollowUpDocument::class, 'vendor_id', 'vendor_id')->orderBy('date_follow_up', 'DESC');
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

    public function checkDocument($categoryId, $vendorId)
    {
        $document = MasterDocument::whereNotNull('document_no')->where('category_id', $categoryId)->where('vendor_id', $vendorId)->first();
        if (isset($document)) {
            return 'Ada';
        }else{
            return  '';
        }
    }
}
