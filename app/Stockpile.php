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

    /**
     * Progress Document Percent
     * @return string
     */
    public function getProgressAttribute()
    {
        $categories = CategoryDocument::where('category_for', 1)->get();
        $totalCategories = count($categories);

        $totalDocument = $totalCategories * $this->total_supplier;

        if ($this->total_document != 0) {
            return number_format($this->total_document / $totalDocument * 100, 2) . '%';
        }
        return '0%';

    }


    /**
     * Jumlah PKS Memiliki Document
     * @return int
     */
    public function getPksHasAnyDocAttribute(): int
    {
        $q = DB::select("SELECT c.vendor_id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN master_document as md ON md.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        AND md.document_no IS NOT NULL AND md.document_date IS NOT NULL
        GROUP BY c.vendor_id");
        return isset($q) ? count($q) : 0;
    }


    /**
     * Jumlah Document Terlampir
     * @return int
     */
    public function getTotalDocumentFileAttribute(): int
    {

       $q = DB::select("SELECT c.vendor_id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN master_document as md ON md.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        AND md.file IS NOT NULL
        GROUP BY c.vendor_id");
        return isset($q) ? count($q) : 0;
    }

    /**
     * Jumlah Document terkumpul
     * @return int
     */
    public function getTotalDocumentAttribute(): int
    {
        $q = DB::select("SELECT (SELECT count(vendor_id) FROM master_document WHERE vendor_id = c.vendor_id AND document_no IS NOT NULL AND document_date IS NOT NULL) as totalDoc FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN master_document as md ON md.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        AND md.document_no IS NOT NULL AND md.document_date IS NOT NULL
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

    public function getPksFollowedUpAttribute(): int
    {
        $q = DB::select("SELECT fud.vendor_id as id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN  follow_up_document as fud ON fud.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        GROUP BY fud.vendor_id");
        return isset($q) ? count($q) : 0;
    }


    /**
     * JUMLAH PKS YANG TELAH MENOLAK MENGIRIMKAN  KELENGKAPAN DOKUMEN
     * @return int
     */
    public function getTotalRejectAttribute()
    {
        $q = DB::select("SELECT vd.vendor_id as id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN  vendor_detail as vd ON vd.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id' AND vd.document_status = 3
        GROUP BY c.vendor_id");
        return isset($q) ? count($q) : 0;
    }

    /**
     * JUMLAH PKS YANG TELAH MENGIRIMKAN  KELENGKAPAN DOKUMEN
     * @return int
     */
    public function getPksSendDocTotalAttribute()
    {
        $q = DB::select("SELECT vd.vendor_id as id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN  vendor_detail as vd ON vd.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id' AND vd.document_status = 2
        GROUP BY c.vendor_id");
        return isset($q) ? count($q) : 0;
    }

    /**
     * JUMLAH PKS YANG TELAH MENERIMA LIST DOKUMEN
     * @return int
     */
    public function getPksGetListDocAttribute()
    {
        $q = DB::select("SELECT vd.vendor_id as id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN  vendor_detail as vd ON vd.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id' AND vd.document_status IN (1,2,3)
        GROUP BY c.vendor_id");
        return isset($q) ? count($q) : 0;
    }

    /**
     * Total PKS Response
     * @return int
     */
    public function getPksResponseAttribute(): int
    {
        $q = DB::select("SELECT md.vendor_id as id FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        RIGHT JOIN  master_document as md ON md.vendor_id = c.vendor_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        GROUP BY c.vendor_id");
        return isset($q) ? count($q) : 0;
    }

    /**
     * Total Supplier
     * @return int
     */
    public function getTotalSupplierAttribute(): int
    {
        $q = DB::select("SELECT COUNT(*) as total FROM stockpile_contract as sc
        LEFT JOIN contract as c ON c.contract_id = sc.contract_id
        WHERE sc.stockpile_id = '$this->stockpile_id'
        GROUP BY c.vendor_id");
        return count($q);
    }

    /**
     * Button Action
     * @return string
     */
    public function getActionButtonAttribute(): string
    {
        return '<a class="btn btn-primary" href="' . route('stockpile.show', $this->stockpile_id) . '">Detail</a>&nbsp;' .
            '<a class="btn btn-success" href="' . route('stockpile.edit', $this->stockpile_id) . '">Edit</a>';
    }

    /**
     * Get all of the supplier for the Stockpile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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

    public function sales()
    {
        return $this->belongsTo(Sales::class, 'stockpile_id', 'stockpile_id');
    }
}
