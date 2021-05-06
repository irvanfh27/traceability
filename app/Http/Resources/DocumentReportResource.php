<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DocumentReportResource extends JsonResource
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
            'stockpile' => 'SP ' . $this->stockpile_name,
            'pks_get_list_doc' => '<a href="#">' . $this->pks_get_list_doc . '</a>',
            'pks_send_doc_total' => '<a href="#">' . $this->pks_send_doc_total . '</a>',
            'total_document' => '<a href="#">' . $this->total_document . '</a>',
        ];
    }
}
