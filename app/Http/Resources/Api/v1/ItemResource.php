<?php

namespace App\Http\Resources\Api\v1;

use App\Http\Resources\Api\v1\User\MerchantResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{

    public function toArray($request)
    {

        $except_arr_resource = $request['except_arr_resource'];
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'calories' => (float)$this->calories,
            'image' => $this->image,
            'price' => $this->price,

            'has_discount' => (bool)$this->has_discount,
            'discount' => $this->discount,
            'price_category' => optional(optional($this->prices()->first())->option_category)->name,
        ];
        if (!is_array($except_arr_resource) || !in_array('classification', $except_arr_resource)) {
            $response['classification'] = new ClassificationResource($this->classification);
        }

//
        if (!is_array($except_arr_resource) || !in_array('prices', $except_arr_resource)) {
            $response['prices'] = PriceResource::collection($this->prices()->where('draft', 0)->get());
        }
////
        if (!is_array($except_arr_resource) || !in_array('addons', $except_arr_resource)) {
            $response['addons'] = AddonResource::collection($this->addons()->where('draft', 0)->get());
        }
////
//

        if (!is_array($except_arr_resource) || !in_array('merchant', $except_arr_resource)) {
            $response['merchant'] = new MerchantResource($this->merchant);
        }


        return $response;


    }
}
