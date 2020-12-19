<?php

namespace App\Http\Resources\Api\v1;

use App\Models\ItemAddon;
use Illuminate\Http\Resources\Json\JsonResource;

class MealOrderResource extends JsonResource
{

    public function toArray($request)
    {
        $except_arr_resource = $request['except_arr_resource'];
        return [
            'id' => $this->item->id,
            'provider_id' => optional($this->item->provider)->id,
            'name' => $this->item->name,
            'description' => $this->item->description,
            'calories' => (float)$this->item->calories,
            'image' => $this->item->image,
            'price_category' => optional(optional($this->item_price)->option_category)->name,
            'price' => [
                'id' => $this->item_price_id,
                'name' =>  optional($this->item_price)->name,
                'price' => (float) $this->price,
                ],
            'quantity' => $this->quantity,
            'total_meal_cost' => $this->amount +  $this->total_addon,
            'classification' => new ClassificationResource($this->item->classification),
            'addons' => AddonOrderResource::collection($this->order_item_addons),

        ];
    }
}
