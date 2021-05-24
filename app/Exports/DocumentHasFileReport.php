<?php

namespace App\Exports;

use App\CategoryDocument;
use App\Stockpile;
use App\Vendor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class DocumentHasFileReport implements FromView
{

    protected $stockpileId;

    public function __construct(int $stockpileId)
    {
        $this->stockpileId = $stockpileId;
    }

    public function view(): View
    {
        $stockpileId = $this->stockpileId;
        $sp = Stockpile::findOrFail($stockpileId);
        $categories = CategoryDocument::where('category_for', 1)->get();

        $vendor = Vendor::whereHas('contract', function ($q) use ($stockpileId) {
            $q->whereHas('stockpileContract', function ($qq) use ($stockpileId) {
                $qq->where('stockpile_id', $stockpileId);
            });
        })->whereHas('documents', function ($q) {
            $q->whereNotNull('file');
        })->get();

        return view('pages.report.excel.documentHasFile', [
            'documents' => $vendor,
            'stockpile' => $sp->stockpile_name,
            'categories' => $categories
        ]);
    }

}
