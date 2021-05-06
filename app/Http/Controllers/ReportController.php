<?php

namespace App\Http\Controllers;

use App\Http\Resources\DocumentReportDetailResource;
use App\Http\Resources\DocumentReportResource;
use App\Http\Resources\StockpileReportResource;
use App\Http\Resources\SupplierReportResource;
use App\Http\Resources\SupplierResource;
use App\Imports\DocumentImport;
use App\MasterDocument;
use App\Vendor;
use App\Stockpile;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return [
                'aaData' => SupplierReportResource::collection(Vendor::all())
            ];
        }
        return view('pages.report.supplier-report');
    }

    public function reportStockpile(Request $request)
    {
        if ($request->ajax()) {
            return [
                'aaData' => StockpileReportResource::collection(Stockpile::all())
            ];
        }
        return view('pages.report.stockpile-report');
    }

    public function reportDocument(Request $request)
    {
        if ($request->ajax()) {
            return [
                'aaData' => DocumentReportResource::collection(Stockpile::all())
            ];
        }
        return view('pages.report.document-report');
    }

    public function detailReportDocument(Request $request)
    {
        //        if ($request->ajax()) {
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
            } elseif ($query == 'hasSentDocument') {
                $vendor = $vendor->whereHas('detail', function ($q) {
                    $q->where('document_status', 2);
                });
            }

            $vendor = $vendor->limit(10)->get();

            return [
                'aaData' => DocumentReportDetailResource::collection($vendor)
            ];
            //        }
            return view('pages.report.document-report');
        }


        public function importDocument($vendorId, Request $r)
        {
            $collection = Excel::toCollection(new DocumentImport($vendorId), $r->file('file'));
            $document = MasterDocument::where('vendor_id', $vendorId)->count();

            if($document > 1){
                return redirect()->route('vendor.show',$vendorId)->with(['error' => 'Error Import Document, Because Already Imported!']);
            }else{
                foreach ($collection[1] as $row) {
                    $departmen = $row['instansi_yang_menerbitkan'];
                    $documentPIC = $row['nama_pejabat_yang_menandatangani'];
                    $remarks = $row['keterangan'];

                    if ($row['dokumen_adatidak'] == 'V') {
                        $documentStatus = 1;
                    } else {
                        $documentStatus = 0;
                    }

                    if ($row['tanggal_dokumen'] == '') {
                        $documentDate = NULL;
                    } else {
                        $documentDate = NULL;
                    }
                    if ($row['tanggal_kadaluarsa'] == '-') {
                        $expiredDate = NULL;
                    } else {
                        $expiredDate = NULL;
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

            return redirect()->route('vendor.show',$vendorId)->with(['success' => 'Success Import Document!']);

        }

    }
