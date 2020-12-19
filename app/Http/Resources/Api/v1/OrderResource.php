<?php

namespace App\Http\Resources\Api\v1;

use App\Http\Resources\Api\v1\User\ProfileResource;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class OrderResource extends JsonResource
{

    public function toArray($request)
    {
        $except_arr_resource = $request['except_arr_resource'];

        $response = [
            'id' => $this->id,
            'uuid' => !is_null($this->uuid) ? '#' . $this->uuid : null,
            'pick_up_time' => Carbon::parse($this->pick_up_time)->format('Y-m-d H:i:s'),
            'pick_up_items' => (int)$this->order_items()->sum('quantity'),
            'status' => $this->status,
            'status_name' => $this->status_name,

            'paid_type' => $this->paid_type,
            'paid_type_name' => $this->paid_name,

            'note' => $this->note,

            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),

            'total_cost' => $this->total_cost,
            'meals_cost' => $this->meals_cost,
            'delivery_cost' => $this->delivery_cost,
            'distance' => optional($this->branch)->distance,
            'commission_delivery_cost' => $this->commission_delivery_cost,
            'driver_slice' => $this->driver_slice,
            'tax_cost' => (float)number_format($this->tax_cost, 2),
            'commission_cost' => (float)number_format($this->commission_cost, 2),
            'coupon_discount' => $this->coupon_discount,
            'wallet_balance' => Auth::guard('api')->check() ? apiUser()->user_wallet : 0,

            'rated' => (bool)$this->rated,

            ];


        if (!is_array($except_arr_resource) || !in_array('rate', $except_arr_resource)) {
            $response['rate'] = new RateResource($this->rate);
        }


        if (!is_array($except_arr_resource) || !in_array('provider', $except_arr_resource)) {
//            $response['provider'] = new ProviderResource($this->provider);
        }

        if (!is_array($except_arr_resource) || !in_array('driver', $except_arr_resource)) {
            $response['driver'] = new ProfileResource($this->driver);
        }


        if (!is_array($except_arr_resource) || !in_array('user', $except_arr_resource)) {
            $response['user'] = new ProfileResource($this->user);
        }

        if (!is_array($except_arr_resource) || !in_array('status_time_line', $except_arr_resource)) {
            $response['status_time_line'] = OrderStatusTimeLineResource::collection(json_decode($this->status_time_line));
        }

        if (!is_array($except_arr_resource) || !in_array('coupon', $except_arr_resource)) {
            $response['coupon'] = new CouponResource($this->coupon);
        }

        if (!is_array($except_arr_resource) || !in_array('meals', $except_arr_resource)) {
            $response['meals'] = MealOrderResource::collection($this->order_items);
        }
        return $response;
    }
}
