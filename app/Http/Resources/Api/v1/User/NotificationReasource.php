<?php

namespace App\Http\Resources\Api\v1\User;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationReasource extends JsonResource
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
            'id' => $this->id,
            'title' => $this->data['title'],
            'body' => $this->data['body'],
            'seen' => (boolean) $this->seen,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
//            'icon' => $this->icon,
            'others' => $this['data']['others'],
        ];
    }
}
