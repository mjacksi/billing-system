<?php

namespace App\Http\Resources\Api\v1;

use App\Http\Resources\Api\v1\User\MerchantTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{

    public function toArray($request)
    {
        $except_arr_resource = $request['except_arr_resource'];
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'isMainBranch' => (bool)$this->isMainBranch,
            'phone' => $this->phone,
            'email' => $this->email,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'gender' => $this->gender,
            'gender_name' => gender($this->gender),
            'code' => $this->generatedCode,
            'distance' => $this->distance,
            'lng' => $this->lng,
            'lat' => $this->lat,
//
            'address' => $this->address,
            'cover' => $this->cover,
            'busy' => (bool)$this->busy,
            'open' => (bool)$this->open,
            'min_price' => (float)$this->min_price,
            'has_discount' => $this->is_discount,
            'max_discount' => $this->max_discount,
            'favorited' => (bool)$this->favorited,
            'work_hour_today' => $this->work_hour_today,
//            'rate' => number_format($this->rate, 1),
        ];
        if (!is_array($except_arr_resource) || !in_array('city', $except_arr_resource)) {
            $response['city'] = new CityResource($this->city);
        }

        if (!is_array($except_arr_resource) || !in_array('providerType', $except_arr_resource)) {
            $response['merchant_type'] = new MerchantTypeResource($this->merchant->merchantType);
        }

        return $response;
    }
}
