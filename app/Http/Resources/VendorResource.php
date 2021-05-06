<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'vendor_name' => $this->vendor_name,
            'vendor_address' => $this->vendor_address,
            'province_name' => $this->province_name,
            'district_name' => $this->district_name,
            'kapasitas_produksi' => $this->kapasitas_produksi,
            'action_button' => $this->action_button
        ];
    }
}
