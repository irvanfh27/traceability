<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'vendor_id' => $this->vendor_id,
            'vendor_name' => $this->vendor_name,
            'vendor_longitude' => $this->vendor_longitude,
            'vendor_latitude' => $this->vendor_latitude,
            'kapasitas_produksi' => $this->kapasitas_produksi,
            'vendor_address' => $this->vendor_address,
            'collection' => number_format($this->collection),
            'button' => '<a href="'.route("vendor.show", $this->vendor_id).'" class="btn btn-primary">Detail</a>'
        ];
    }
}
