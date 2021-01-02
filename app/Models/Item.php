<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $guarded = [];


    public function getStatusNameAttribute()
    {
        return draftName($this->draft);
    }

    public function bills()
    {
        return $this->belongsToMany(BillItems::class, BillItems::class, 'item_id', 'bill_id');
    }


    public function getActionButtonsAttribute()
    {
        $route = 'items';

        if (auth()->guard('manager')->check()){
            $button = '';
            $button .= '<a href="' . route('manager.' . $route . '.edit', $this->id) . '" class="btn btn-icon btn-danger "><i class="la la-pencil"></i></a> ';
//        $button .= '<a href="' . route('manager.' . $route . '.show', $this->id) . '" class="btn btn-icon btn-danger "><i class="la la-eye"></i></a> ';
            $button .= '<button type="button" data-id="' . $this->id . '" data-toggle="modal" data-target="#deleteModel" class="deleteRecord btn btn-icon btn-danger"><i class="la la-trash"></i></button>';

        }else if (auth()->guard('accountant')->check()){
            $button = '';
//            $button .= '<a href="' . route('manager.' . $route . '.edit', $this->id) . '" class="btn btn-icon btn-danger disabled  "><i class="la la-pencil"></i></a> ';
//        $button .= '<a href="' . route('manager.' . $route . '.show', $this->id) . '" class="btn btn-icon btn-danger "><i class="la la-eye"></i></a> ';
//            $button .= '<button disabled type="button" data-id="' . $this->id . '" data-toggle="modal" data-target="#deleteModel" class="deleteRecord btn btn-icon btn-danger"><i class="la la-trash"></i></button>';
        }else{
            $guard = 'web';
        }
        return $button;

    }


}
