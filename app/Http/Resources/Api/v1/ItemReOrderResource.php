<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemReOrderResource extends JsonResource
{
    public function toArray($request)
    {
        $except_arr_resource = $request['except_arr_resource'];

        return [
            'id' => $this->item->id,
            'provider_id' => optional(optional($this->item)->provider)->id,
            'name' => $this->item->name,
            'description' => $this->description,
            'calories' => (float)$this->calories,
            'image' => $this->item->image,
            'classification' => new ClassificationResource($this->item->classification),
            'price_category' => optional(optional($this->item->prices()->first())->option_category)->name,
            'price' => new PriceResource($this->item_price()->notDraft()->first()),
            'addons' => AddonResource::collection($this->order_item_addons()->dd()/*->notDraft()*/->get()),
        ];
    }
}
