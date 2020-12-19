<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $guarded = [];


    public function getStatusNameAttribute()
    {
        switch ($this->draft) {
            case YES:
                return t('Draft');
            case NO:
                return t('Not Draft');
            default:
                return t('unknown status');
                break;
        }
    }

    public function getActionButtonsAttribute()
    {
        $route = 'items';

        $button = '';
        $button .= '<a href="' . route('manager.' . $route . '.edit', $this->id) . '" class="btn btn-icon btn-danger "><i class="la la-pencil"></i></a> ';
//        $button .= '<a href="' . route('manager.' . $route . '.show', $this->id) . '" class="btn btn-icon btn-danger "><i class="la la-eye"></i></a> ';
        $button .= '<button type="button" data-id="' . $this->id . '" data-toggle="modal" data-target="#deleteModel" class="deleteRecord btn btn-icon btn-danger"><i class="la la-trash"></i></button>';

        return $button;
    }



}
