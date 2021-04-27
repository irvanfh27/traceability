<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockpileReportResource extends JsonResource
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
            'stockpile_name' => $this->stockpile_name,
            'pks_not_followed_up' => $this->pks_not_followed_up,
            'pks_followed_up' => $this->pks_followed_up,
            'pks_response' => $this->pks_response,
            'total_document' => $this->total_document,
            'progress' => $this->progress
        ];
    }
}
