<?php

namespace App\Http\Controllers;

use App\CategoryDocument;
use App\Http\Resources\DocumentReportDetailResource;
use App\Http\Resources\DocumentReportResource;
use App\Http\Resources\StockpileReportResource;
use App\Http\Resources\SupplierReportResource;
use App\Http\Resources\SupplierResource;
use App\Imports\DocumentImport;
use App\MasterDocument;
use App\Vendor;
use App\Stockpile;
use App\Transaction;
use App\VendorGroup;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Shipment;



class ReportController extends Controller
{
    /**
     * Supplier Report
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return [
                'aaData' => SupplierReportResource::collection(Vendor::all())
            ];
        }
        return view('pages.report.supplier-report');
    }

    /**
     * Report Stockpile
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportStockpile(Request $request)
    {
        if ($request->ajax()) {
            return [
                'aaData' => StockpileReportResource::collection(Stockpile::all())
            ];
        }
        return view('pages.report.stockpile-report');
    }

    /**
     * List Report Progress Document
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function reportDocument(Request $request)
    {
        if ($request->ajax()) {
            return [
                'aaData' => DocumentReportResource::collection(Stockpile::all())
            ];
        }
        return view('pages.report.document-report');
    }

    /**
     * Detail Report Progress Document
     * @param Request $request
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detailReportDocument(Request $request)
    {
        if ($request->q == 'receiveListDocument') {
            $title = 'Jumlah PKS Penerima Ceklist Dok';
        } elseif ($request->q == 'hasSentDocument') {
            $title = 'Jumlah PKS Merespon';
        } elseif ($request->q == 'hasAnyDocumentNo') {
            $title = 'Jumlah Ceklist Dokumen Terkumpul';
        } elseif ($request->q == 'hasAnyDocumentFile') {
            $title = 'Jumlah Dokumen Terlampir';
        } elseif ($request->q == 'hasRejectDocument') {
            $title = 'Jumlah PKS YANG MENOLAK';
        }

        if ($request->q == 'hasAnyDocumentFile') {
            $stockpileId = $request->stockpileId;

            $vendor = Vendor::whereHas('contract', function ($q) use ($stockpileId) {
                $q->whereHas('stockpileContract', function ($qq) use ($stockpileId) {
                    $qq->where('stockpile_id', $stockpileId);
                });
            })->whereHas('documents', function ($q) {
                $q->whereNotNull('file');
            })->get();

            $sp = Stockpile::findOrFail($stockpileId);
            $stockpile = $sp->stockpile_name;
            $categories = CategoryDocument::where('category_for', 1)->get();
            return view('pages.report.document-report-detail', compact('stockpile', 'categories', 'vendor', 'title'));

        }

        if ($request->ajax()) {
            $stockpileId = $request->stockpileId;
            $query = $request->q;

            $vendor = Vendor::whereHas('contract', function ($q) use ($stockpileId) {
                $q->whereHas('stockpileContract', function ($qq) use ($stockpileId) {
                    $qq->where('stockpile_id', $stockpileId);
                });
            });

            if ($query == 'receiveListDocument') {
                $vendor = $vendor->whereHas('detail', function ($q) {
                    $q->whereIn('document_status', [1, 2]);
                });
                $title = 'JUMLAH PKS YANG TELAH MENERIMA LIST DOKUMEN';
            } elseif ($query == 'hasSentDocument') {
                $vendor = $vendor->whereHas('detail', function ($q) {
                    $q->where('document_status', 2);
                });
                $title = 'JUMLAH PKS YANG TELAH MENGIRIMKAN  KELENGKAPAN DOKUMEN';
            } elseif ($query == 'hasAnyDocumentNo') {
                $vendor = $vendor->whereHas('documents', function ($q) {
                    $q->whereNotNull('document_no')->whereNotNull('document_date');
                });
            } elseif ($query == 'hasRejectDocument') {
                $vendor = $vendor->whereHas('detail', function ($q) {
                    $q->where('document_status', 3);
                });
            }
            $vendor = $vendor->get();

            return [
                'aaData' => DocumentReportDetailResource::collection($vendor)
            ];
        }

        return view('pages.report.document-report-detail', compact('title'));
    }

    /**
     * Import Excel Document Data
     * @param $vendorId
     * @param Request $r
     * @return \Illuminate\Http\RedirectResponse
     */
    public function importDocument($vendorId, Request $r)
    {
        $collection = Excel::toCollection(new DocumentImport($vendorId), $r->file('file'));
        $document = MasterDocument::where('vendor_id', $vendorId)->count();
        // return $collection;
        if ($document > 1) {
            return redirect()->route('vendor.show', $vendorId)->with(['error' => 'Error Import Document, Because Already Imported!']);
        } else {
            foreach ($collection[1] as $row) {
                $departmen = $row['instansi_yang_menerbitkan'];
                $documentPIC = $row['nama_pejabat_yang_menandatangani'];
                $remarks = $row['keterangan'];

                if ($row['dokumen_adatidak'] == 'V') {
                    $documentStatus = 1;
                } else {
                    $documentStatus = 0;
                }

                if ($row['tanggal_dokumen'] == '' || $row['tanggal_dokumen'] == '-') {
                    $documentDate = NULL;
                } else {
                    $documentDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_dokumen']));
                }
                if ($row['tanggal_kadaluarsa'] == '' || $row['tanggal_kadaluarsa'] == '-') {
                    $expiredDate = NULL;
                } else {
                    $expiredDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_kadaluarsa']));
                }
                MasterDocument::create([
                    'category_id' => $row['no'],
                    'document_name' => $row['nama_dokumen'],
                    'document_no' => $row['nomor_dokumen'],
                    'document_date' => $documentDate,
                    'expired_date' => $expiredDate,
                    'vendor_id' => $vendorId,
                    'department' => $departmen,
                    'document_status' => $documentStatus,
                    'document_pic' => $documentPIC,
                    'remarks' => $remarks,
                    'status' => 1,
                    'created_by' => auth()->user()->id,
                ]);
            }
        }

        return redirect()->route('vendor.show', $vendorId)->with(['success' => 'Success Import Document!']);

    }

    /**
     * @param Request $request
     */
    public function reportGroupSupplier(Request $request)
    {
        $vendorGroups = VendorGroup::all();

        return view('pages.report.supplier-group-report',compact('vendorGroups'));
    }

    public function selectSearchShipment(Request $request)
    {
        //$userIdGis = auth()->user()->id;
        //$userIdJatim = DB::table('user')->select('user_id')->where('user_email', '=', DB::raw("(select email from users_gis where id = $userIdGis)"))->get();
        $shipment = DB::table('shipment as sh')->join('sales as sl','sl.sales_id','=','sh.sales_id')->join('stockpile as s','s.stockpile_id','sl.stockpile_id')
        ->select('sh.shipment_id','sh.sales_id', 
        DB::raw("concat(s.stockpile_code, ' - ', sh.shipment_date, ' - ', sh.shipment_no, ' - ' , RIGHT(sh.shipment_code ,2)) AS shipment_code"))
        ->where('sh.shipment_status','=', 1)
        ->whereIn('sl.stockpile_id', [DB::raw("SELECT stockpile_id FROM user_stockpile WHERE user_id = 47")])
        ->groupByRaw('sh.sales_id')->orderByDesc('sh.shipment_date')->orderByDesc('sh.shipment_code')
        ->get();
        if($request->has('q')){
            $search = $request->q;
            $shipment = DB::table('shipment as sh')->join('sales as sl','sl.sales_id','=','sh.sales_id')->join('stockpile as s','s.stockpile_id','sl.stockpile_id')
                        ->select('sh.shipment_id','sh.sales_id', 
                        DB::raw("concat(s.stockpile_code, ' - ', sh.shipment_date, ' - ', sh.shipment_no, ' - ' , RIGHT(sh.shipment_code ,2)) AS shipment_code"))
                        ->where('sh.shipment_status','=', 1)
                        ->whereIn('sl.stockpile_id', [DB::raw("SELECT stockpile_id FROM user_stockpile WHERE user_id = 47")])
                        ->where('shipment_code', 'LIKE', "%$search%")
                        ->groupByRaw('sh.sales_id')->orderByDesc('sh.shipment_date')->orderByDesc('sh.shipment_code')
                        ->get();
        }
        return response()->json($shipment);
    }

    public function pksTraceabilityReport (Request $request){
        $salesId = $request->salesId;
        $pks = DB::table('delivery as d')->leftJoin('transaction as t', 't.transaction_id', '=', 'd.transaction_id')->leftJoin('transaction_timbangan as tt','tt.transaction_id','=','t.t_timbangan')
            ->leftJoin('stockpile_contract as sc','sc.stockpile_contract_id','=','t.stockpile_contract_id')
            ->leftJoin('stockpile as s', 's.stockpile_id','=','sc.stockpile_id')->leftJoin('contract as con','con.contract_id','=','sc.contract_id')->leftJoin('vendor as v1','v1.vendor_id','=','con.vendor_id')
            ->leftJoin('vendor_detail as v1d','v1d.vendor_id','=','v1.vendor_id')->leftJoin('unloading_cost as uc','uc.unloading_cost_id','=','t.unloading_cost_id')->leftJoin('vehicle as vh','vh.vehicle_id','=','uc.vehicle_id')
            ->leftJoin('freight_cost as fc','fc.freight_cost_id','=','t.freight_cost_id')->leftJoin('freight as f','f.freight_id','=','fc.freight_id')->leftJoin('vendor as v2','v2.vendor_id','=','fc.vendor_id')->leftJoin('vendor as v3','v3.vendor_id','=','t.vendor_id')
            ->leftJoin('shipment as sh','sh.shipment_id','=','d.shipment_id')->leftJoin('sales as sl','sl.sales_id','=','sh.sales_id')->leftJoin('stockpile as s2','s2.stockpile_id','=','sl.stockpile_id')
            ->leftJoin('customer as cust','cust.customer_id','=','sl.customer_id')->leftJoin('tax as fctxpph','fctxpph.tax_id','=','t.fc_tax_id')->leftJoin('tax as fctxppn','fctxppn.tax_id','=','f.ppn_tax_id')->leftJoin('labor as l','l.labor_id','=','t.labor_id')
            ->leftJoin('tax as uctxpph','uctxpph.tax_id','=','l.pph_tax_id')->leftJoin('tax as uctxppn','uctxppn.tax_id','=','l.ppn_tax_id')->leftJoin('vendor_handling_cost as vhc','vhc.handling_cost_id','=','t.handling_cost_id')->leftJoin('vendor_handling as vh1','vh1.vendor_handling_id','=','vhc.vendor_handling_id')
            ->leftJoin('tax as vhtx','vhtx.tax_id','=','vh1.pph_tax_id')
            ->select('d.*', 'tt.transaction_in', 'tt.slip as tiketTimbang', 'con.contract_no', 't.slip_no', 't.permit_no','con.po_no',
                    'v3.vendor_name AS supplier','v1.vendor_name', 'v1.vendor_code','sh.shipment_no','t.send_weight','t.netto_weight', 'd.quantity',
                    't.freight_quantity', 't.freight_price','t.unloading_price','vhc.price AS vh_price', 't.handling_quantity',
                    'vh1.pph_tax_id AS vh_pph_tax_id', 'vh1.pph AS vh_pph', 'vhtx.tax_category AS vh_pph_tax_category','f.ppn_tax_id AS fc_ppn_tax_id',
                    'f.ppn AS fc_ppn', 'fctxppn.tax_category AS fc_ppn_tax_category','t.fc_tax_id AS fc_pph_tax_id', 'fctxpph.tax_value AS fc_pph',
                    'fctxpph.tax_category AS fc_pph_tax_category', 'l.ppn_tax_id AS uc_ppn_tax_id', 'l.ppn AS uc_ppn','l.labor_id','t.freight_cost_id',
                    'uctxppn.tax_category AS uc_ppn_tax_category', 'l.pph_tax_id AS uc_pph_tax_id', 'l.pph AS uc_pph', 'uctxpph.tax_category AS uc_pph_tax_category',
                    'f.freight_id', 'v1d.distance', 'v1d.ghg',
            DB::raw('CASE WHEN t.transaction_type = 1 THEN s.stockpile_name ELSE s2.stockpile_name END AS stockpile_name'),
            DB::raw('DATE_FORMAT(t.unloading_date, "%d %b %Y") AS transaction_date2'),
            DB::raw('DATE_FORMAT(t.loading_date, "%d %b %Y") AS tglMuat'),
            DB::raw("CONCAT(DATE_FORMAT('t.loading_date', '%d%m%Y'), ' - ', t.vehicle_no) AS kodeMasukMobil"),
            DB::raw("CONCAT(DATE_FORMAT(t.unloading_date, '%d%m%Y'), ' - ', t.vehicle_no, ' - ', SUBSTRING(tt.transaction_in, 11, 9)) AS KodeTerima"),
            DB::raw("CASE WHEN con.contract_type = 'P' THEN 'PKS' ELSE 'Curah' END AS contract_type2"),
            DB::raw("CONCAT(f.freight_code, '-', v2.vendor_code) AS freight_code"),
            DB::raw("(SELECT GROUP_CONCAT(vc.vendor_curah_code,' - ',vc.vendor_curah_name) FROM vendor_curah vc LEFT JOIN contract_pks_detail cpd ON vc.vendor_curah_id = cpd.vendor_curah_id WHERE cpd.contract_id = con.contract_id) AS vendor_curah_name"),
            DB::raw("CASE WHEN t.mutasi_id IS NOT NULL THEN t.unit_cost WHEN t.adjustmentAudit_id IS NOT NULL THEN t.unit_price ELSE con.price_converted END AS price_converted"),
            DB::raw("CASE WHEN t.mutasi_id IS NOT NULL THEN d.quantity * t.unit_cost WHEN t.adjustmentAudit_id IS NOT NULL THEN d.quantity * t.unit_price ELSE d.quantity * con.price_converted END AS cogs_amount"),
            DB::raw("CASE WHEN t.delivery_status = 2 THEN (d.percent_taken / 100) * (t.quantity * t.freight_price) ELSE (d.percent_taken / 100) * (t.freight_quantity * t.freight_price) END AS freight_total"),
            DB::raw("CASE WHEN t.delivery_status = 2 AND t.freight_cost_id IS NOT NULL THEN (d.quantity/t.freight_quantity) * COALESCE((SELECT amt_claim FROM transaction_shrink_weight WHERE transaction_id = d.transaction_id),0)
	    	        WHEN t.freight_cost_id IS NOT NULL THEN (d.percent_taken / 100) * COALESCE((SELECT amt_claim FROM transaction_shrink_weight WHERE transaction_id = d.transaction_id),0) ELSE 0 END AS freight_shrink"),
            DB::raw("(d.percent_taken / 100) * t.unloading_price AS unloading_total"),
            DB::raw("CASE WHEN t.delivery_status = 2 THEN (d.percent_taken / 100) * (t.handling_quantity * vhc.price) ELSE (d.percent_taken / 100) * (t.handling_quantity * vhc.price) END AS handling_total"),
            DB::raw("CASE WHEN d.qty_ggl > 0 THEN 'GGL'
            WHEN d.qty_rsb > 0  THEN 'RSB'
            WHEN d.qty_rsb_ggl > 0 THEN 'RSB + GGL'
            WHEN d.qty_uncertified > 0 THEN 'Uncertified'
            ELSE 'Uncertified' END AS sertifikat"))
            ->where('sh.sales_id','=',$salesId)
            ->orderBy('t.slip_no')->orderBy('d.transaction_id')->get();

            $pks1 = DB::table('delivery as d')->leftJoin('transaction as t', 't.transaction_id', '=', 'd.transaction_id')->leftJoin('stockpile_contract as sc','sc.stockpile_contract_id','=','t.stockpile_contract_id')
            ->leftJoin('stockpile as s', 's.stockpile_id','=','sc.stockpile_id')->leftJoin('contract as con','con.contract_id','=','sc.contract_id')->leftJoin('vendor as v1','v1.vendor_id','=','con.vendor_id')
            ->leftJoin('vendor_detail as v1d','v1d.vendor_id','=','v1.vendor_id')->leftJoin('unloading_cost as uc','uc.unloading_cost_id','=','t.unloading_cost_id')->leftJoin('vehicle as vh','vh.vehicle_id','=','uc.vehicle_id')
            ->leftJoin('freight_cost as fc','fc.freight_cost_id','=','t.freight_cost_id')->leftJoin('freight as f','f.freight_id','=','fc.freight_id')->leftJoin('vendor as v2','v2.vendor_id','=','fc.vendor_id')->leftJoin('vendor as v3','v3.vendor_id','=','t.vendor_id')
            ->leftJoin('shipment as sh','sh.shipment_id','=','d.shipment_id')->leftJoin('sales as sl','sl.sales_id','=','sh.sales_id')->leftJoin('stockpile as s2','s2.stockpile_id','=','sl.stockpile_id')
            ->leftJoin('customer as cust','cust.customer_id','=','sl.customer_id')->leftJoin('tax as fctxpph','fctxpph.tax_id','=','t.fc_tax_id')->leftJoin('tax as fctxppn','fctxppn.tax_id','=','f.ppn_tax_id')->leftJoin('labor as l','l.labor_id','=','t.labor_id')
            ->leftJoin('tax as uctxpph','uctxpph.tax_id','=','l.pph_tax_id')->leftJoin('tax as uctxppn','uctxppn.tax_id','=','l.ppn_tax_id')->leftJoin('vendor_handling_cost as vhc','vhc.handling_cost_id','=','t.handling_cost_id')->leftJoin('vendor_handling as vh1','vh1.vendor_handling_id','=','vhc.vendor_handling_id')
            ->leftJoin('tax as vhtx','vhtx.tax_id','=','vh1.pph_tax_id')
            ->select('d.*',DB::raw('CASE WHEN t.transaction_type = 1 THEN s.stockpile_name ELSE s2.stockpile_name END AS stockpile_name'),DB::raw('DATE_FORMAT(t.unloading_date, "%d %b %Y") AS transaction_date2'),'t.slip_no',DB::raw("CASE WHEN con.contract_type = 'P' THEN 'PKS' ELSE 'Curah' END AS contract_type2"),'con.po_no',DB::raw("CONCAT(f.freight_code, '-', v2.vendor_code) AS freight_code"),
            'v3.vendor_name AS supplier','v1.vendor_name','sh.shipment_code','t.send_weight','t.netto_weight', 'd.quantity',db::raw("CASE WHEN t.mutasi_id IS NOT NULL THEN t.unit_cost WHEN t.adjustmentAudit_id IS NOT NULL THEN t.unit_price ELSE con.price_converted END AS price_converted"),
            DB::raw("CASE WHEN t.mutasi_id IS NOT NULL THEN d.quantity * t.unit_cost WHEN t.adjustmentAudit_id IS NOT NULL THEN d.quantity * t.unit_price ELSE d.quantity * con.price_converted END AS cogs_amount"),'t.freight_quantity', 't.freight_price',db::raw("CASE WHEN t.delivery_status = 2 THEN (d.percent_taken / 100) * (t.quantity * t.freight_price) ELSE (d.percent_taken / 100) * (t.freight_quantity * t.freight_price) END AS freight_total"),
            DB::raw("CASE WHEN t.delivery_status = 2 AND t.freight_cost_id IS NOT NULL THEN (d.quantity/t.freight_quantity) * COALESCE((SELECT amt_claim FROM transaction_shrink_weight WHERE transaction_id = d.transaction_id),0)
	    	WHEN t.freight_cost_id IS NOT NULL THEN (d.percent_taken / 100) * COALESCE((SELECT amt_claim FROM transaction_shrink_weight WHERE transaction_id = d.transaction_id),0) ELSE 0 END AS freight_shrink"),'t.unloading_price', DB::raw("(d.percent_taken / 100) * t.unloading_price AS unloading_total"),'vhc.price AS vh_price', 't.handling_quantity',
            DB::raw("CASE WHEN t.delivery_status = 2 THEN (d.percent_taken / 100) * (t.handling_quantity * vhc.price) ELSE (d.percent_taken / 100) * (t.handling_quantity * vhc.price) END AS handling_total"),'vh1.pph_tax_id AS vh_pph_tax_id', 'vh1.pph AS vh_pph', 'vhtx.tax_category AS vh_pph_tax_category','f.ppn_tax_id AS fc_ppn_tax_id', 'f.ppn AS fc_ppn', 'fctxppn.tax_category AS fc_ppn_tax_category',
            't.fc_tax_id AS fc_pph_tax_id', 'fctxpph.tax_value AS fc_pph', 'fctxpph.tax_category AS fc_pph_tax_category', 'l.ppn_tax_id AS uc_ppn_tax_id', 'l.ppn AS uc_ppn', 'uctxppn.tax_category AS uc_ppn_tax_category', 'l.pph_tax_id AS uc_pph_tax_id', 'l.pph AS uc_pph', 'uctxpph.tax_category AS uc_pph_tax_category','l.labor_id','t.freight_cost_id', 'f.freight_id',
            DB::raw("(SELECT slip_no FROM TRANSACTION WHERE notim_status != 1 AND slip_retur IS NULL AND shipment_id = (SELECT shipment_id FROM shipment WHERE sales_id = sl.sales_id ORDER BY shipment_id ASC LIMIT 1)LIMIT 1) AS slipOut"),
            DB::raw("(SELECT transaction_date FROM TRANSACTION WHERE notim_status != 1 AND slip_retur IS NULL AND shipment_id = (SELECT shipment_id FROM shipment WHERE sales_id = sl.sales_id ORDER BY shipment_id ASC LIMIT 1)LIMIT 1) AS transactionDate"),
            DB::raw("(SELECT SUBSTRING(slip_no,1,3) FROM TRANSACTION WHERE notim_status != 1 AND slip_retur IS NULL AND shipment_id = (SELECT shipment_id FROM shipment WHERE sales_id = sl.sales_id ORDER BY shipment_id ASC LIMIT 1)LIMIT 1) AS slipOutCode"),
            DB::raw("(SELECT vehicle_no FROM TRANSACTION WHERE notim_status != 1 AND slip_retur IS NULL AND shipment_id = (SELECT shipment_id FROM shipment WHERE sales_id = sl.sales_id ORDER BY shipment_id ASC LIMIT 1)LIMIT 1) AS vessel_name"), 'sh.shipment_no')
            ->where('sh.sales_id','=',$salesId)
            ->orderBy('t.slip_no')->orderBy('d.transaction_id')->get();

        return view('pages.report.pks-traceability-report',compact('pks','pks1'));
    }

}
