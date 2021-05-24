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
            'pks_get_list_doc' => '<a href="'.route('report.document.detail',['stockpileId' => $this->stockpile_id, 'q' => 'receiveListDocument']).'">' . $this->pks_get_list_doc . '</a>',
            'pks_send_doc_total' => '<a href="'.route('report.document.detail',['stockpileId' => $this->stockpile_id, 'q' => 'hasSentDocument']).'">' . $this->pks_send_doc_total . '</a>',
            'total_document' => '<a href="'.route('report.document.detail',['stockpileId' => $this->stockpile_id, 'q' => 'hasAnyDocumentNo']).'">' . $this->pksHasAnyDoc . '</a>',
            'total_document_file' => '<a href="'.route('report.document.detail',['stockpileId' => $this->stockpile_id, 'q' => 'hasAnyDocumentFile']).'">' . $this->TotalDocumentFile . '</a>',
            'total_reject' => '<a href="'.route('report.document.detail',['stockpileId' => $this->stockpile_id, 'q' => 'hasRejectDocument']).'">' . $this->total_reject . '</a>',
        ];
    }
}
