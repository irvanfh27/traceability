<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockpileMapsResource extends JsonResource
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
            'type' => 'Feature',
            'properties' => [
                'stockpileId' => $this->stockpile_id,
                'address' => $this->stockpile_address,
                'totalSupplier' => $this->total_supplier,
                'stockpileName' => $this->stockpile_name,
                'title' => $this->stockpile_name,
                'url' => route('stockpile.show',$this->stockpile_id),
                'urlSupplier' => route('api.supplierByStockpile',$this->stockpile_id)
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [$this->longitude, $this->latitude],
            ],
        ];
    }
}
