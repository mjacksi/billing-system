<?php

namespace App\Http\Resources\Api\v1\User;

use App\Http\Resources\Api\v1\CityResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {

        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'phone' => $this->phone,
            'email' => $this->email,
            'type' => $this->type,
            'type_name' => $this->account_type_name,
            'verified' => (bool)$this->verified,
            'status' => $this->status,
            'status_name' => $this->status_name,
            'gender' => $this->gender,
            'gender_name' => gender($this->gender),
            'fcm_token' => $this->fcm_token,
            'code' => $this->generatedCode,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'city' => new CityResource($this->city),

            'dob' => $this->dob,
            'rate' => $this->rate,
            'local' => $this->local,
            'notification' => (bool)$this->notification,
            'unread_notifications' => (int)$this->unread_notifications,
            'wallet_balance' => $this->wallet_balance,
            'access_token' => $this->access_token,

        ];

        if ($this->type == User::DRIVER) $response['whatsapp'] = $this->whatsapp;
        return $response;
    }
}
