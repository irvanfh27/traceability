<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StockpileResource extends JsonResource
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
            'stockpile_id' => $this->stockpile_id,
            'stockpile_name' => $this->stockpile_name,
            'stockpile_address' => $this->stockpile_address,
            'stockpile_provinsi' => $this->stockpile_provinsi,
            'stockpile_kabupaten' => $this->stockpile_kabupaten,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'action' => $this->action_button
        ];
    }
}
