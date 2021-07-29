<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MapResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $long = isset($this->detail->longitude) ? $this->detail->longitude : 0;
        $lat = isset($this->detail->latitude) ? $this->detail->latitude : 0;
        $distance = isset($this->detail->distance) ? $this->detail->distance / 1000 : 0;

        return [
            'type' => 'Feature',
            'properties' => [
                'distance' => number_format($distance,3) .' KM',
                'vendor' => $this->vendor_name,
                'title' => $this->vendor_name,
                'address' => $this->vendor_address,
                'url' => route('vendor.show',$this->vendor_id),
                'kapasitas_produksi' => $this->kapasitas_produksi_ton,
                'collection' => $this->collection_ton,
                'collection_rate' => $this->collection_rate
            ],
            'geometry' => [
                'type' => 'Point',
                'coordinates' => [floatval($long),floatval($lat)]
            ],
        ];
    }
}
