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

        $documents = [
            '1' => $this->checkDocument(1, $this->vendor_id),
            '2' => $this->checkDocument(2, $this->vendor_id),
            '3' => $this->checkDocument(3, $this->vendor_id),
            '4' => $this->checkDocument(4, $this->vendor_id),
            '5' => $this->checkDocument(5, $this->vendor_id),
            '5' => $this->checkDocument(5, $this->vendor_id),
            '7' => $this->checkDocument(7, $this->vendor_id),
            '8' => $this->checkDocument(8, $this->vendor_id),
            '9' => $this->checkDocument(9, $this->vendor_id),
            '10' => $this->checkDocument(10, $this->vendor_id),
            '11' => $this->checkDocument(11, $this->vendor_id),
            '12' => $this->checkDocument(12, $this->vendor_id),
            '13' => $this->checkDocument(13, $this->vendor_id),
            '14' => $this->checkDocument(14, $this->vendor_id),
            '15' => $this->checkDocument(15, $this->vendor_id),
            '16' => $this->checkDocument(16, $this->vendor_id),
            '17' => $this->checkDocument(17, $this->vendor_id),
            '18' => $this->checkDocument(18, $this->vendor_id),
            '19' => $this->checkDocument(19, $this->vendor_id),
            '20' => $this->checkDocument(20, $this->vendor_id),
            '21' => $this->checkDocument(21, $this->vendor_id),
            '22' => $this->checkDocument(22, $this->vendor_id),
            '23' => $this->checkDocument(23, $this->vendor_id),
            '24' => $this->checkDocument(24, $this->vendor_id),
            '25' => $this->checkDocument(25, $this->vendor_id),
            '26' => $this->checkDocument(26, $this->vendor_id),
            '27' => $this->checkDocument(27, $this->vendor_id),
            '28' => $this->checkDocument(28, $this->vendor_id),
            '29' => $this->checkDocument(29, $this->vendor_id),
            '30' => $this->checkDocument(30, $this->vendor_id),
            '31' => $this->checkDocument(31, $this->vendor_id),
            '32' => $this->checkDocument(32, $this->vendor_id),
            '33' => $this->checkDocument(33, $this->vendor_id),
            '34' => $this->checkDocument(34, $this->vendor_id),
            '35' => $this->checkDocument(35, $this->vendor_id),
            '36' => $this->checkDocument(36, $this->vendor_id),
            '37' => $this->checkDocument(37, $this->vendor_id),
            '38' => $this->checkDocument(38, $this->vendor_id),
            '39' => $this->checkDocument(39, $this->vendor_id),
            '40' => $this->checkDocument(40, $this->vendor_id),
            '41' => $this->checkDocument(41, $this->vendor_id),
            '42' => $this->checkDocument(42, $this->vendor_id),
            '43' => $this->checkDocument(43, $this->vendor_id),
            '44' => $this->checkDocument(44, $this->vendor_id),
        ];

        $data = [
            'stockpile' => 'SP ' . $sp->stockpile_name,
            'vendor_id' => $this->vendor_id,
            'vendor_name' => '<a href="' . route("vendor.show", $this->vendor_id) . '" class="badge badge-info" style="font-size:13px;color:white">' . $this->vendor_name . '</a>',
            'document_status' => $this->document_status,
            'total_document' => $this->total_document . '/' . $this->TotalCatDocSupplier,
            'percentage_document' => $this->percentage_document,
            'comment' => isset($this->latestFollowUp) ? $this->latestFollowUp->keterangan : '',
        ];

        if (request()->q == 'hasAnyDocumentFile') {
            $data = array_merge($data,$documents);
        }
        return $data;
    }
}
