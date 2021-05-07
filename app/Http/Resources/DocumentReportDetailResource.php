<?php

namespace App\Http\Resources;

use App\Stockpile;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentReportDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $sp = Stockpile::findOrFail(request()->stockpileId);
        return [
            'stockpile' => 'SP ' . $sp->stockpile_name,
            'vendor_id' => $this->vendor_id,
            'vendor_name' =>  '<a href="' . route("vendor.show", $this->vendor_id) . '" class="badge badge-info" style="font-size:13px;color:white">' . $this->vendor_name . '</a>',
            'document_status' => $this->document_status,
            'total_document' => $this->total_document,
            'percentage_document' => $this->percentage_document,
            'comment' => isset($this->latestFollowUp) ? $this->latestFollowUp->keterangan : ''
        ];
    }
}
