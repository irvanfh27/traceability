<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'vendor' => $this->vendor_name,
            'total_document' => $this->total_document,
            'percentage_document' => $this->percentage_document,
            'date_follow_up' => isset($this->latestFollowUp->date_follow_up) ? $this->latestFollowUp->date_follow_up : "",
            'keterangan' => isset($this->latestFollowUp->keterangan) ? $this->latestFollowUp->keterangan : ""
        ];
    }
}
