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
        $long = isset($this->detail->longitude) ? $this->detail->longitude : $this->vendor_longitude;
        $lat = isset($this->detail->latitude) ? $this->detail->latitude : $this->vendor_latitude;

        return [
            'type' => 'Feature',
            'properties' => [
                'distance' => $this->distance / 1000 .' KM',
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
