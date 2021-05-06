<?php

namespace App\Http\Resources;

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
        return [
            'stockpile' => $this->stockpile_name,
            'vendor_id' => $this->vendor_id,
            'vendor_name' => $this->vendor_name,
            'vendor_longitude' => $this->vendor_longitude,
            'vendor_latitude' => $this->vendor_latitude,
            'kapasitas_produksi' => $this->kapasitas_produksi,
            'vendor_address' => $this->vendor_address,
            'collection' => number_format($this->collection),
            'document_status' => $this->document_status,
        ];
    }
}
