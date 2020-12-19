<?php

namespace App\Http\Resources\Api\v1;

use App\Models\Rate;
use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
{

    public function toArray($request)
    {
        $except_arr_resource = $request['except_arr_resource'];

        $response = [
            'id' => $this->id,
            'uuid' => optional($this->order)->uuid,
            'rate' => (double)$this->rate,
            'comment' => $this->comment,
            'date' => $this->created_at->format(DATE_FORMAT),
            'time' => $this->created_at->format(TIME_FORMAT),
        ];
        if ($this->source == Rate::DRIVER) {
            $response['username'] = optional($this->driver)->name;
        } else {
//            the source is user
            if ($this->rate_type == Rate::DRIVER_RATE_TYPE) {
                $response['username'] = optional($this->user)->name;
            } else {
                $response['username'] = optional(optional($this->order)->provider)->name;
            }
        }


        return $response;
    }
}
