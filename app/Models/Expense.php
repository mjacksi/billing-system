<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Model;


class Expense extends Model
{
    protected $table = 'expenses';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot(); //  Change the autogenerated stub
        static::addGlobalScope('orderedBy', function (Builder $builder) {
            $builder->orderBy('ordered');
        });

        if (!request()->is('manager/bills') && !request()->is('manager/bills/*')) {
            static::addGlobalScope('notDraft', function (Builder $builder) {
                $builder->where('draft', false);
            });
        }

    }


    public function getActionButtonsAttribute()
    {
        $route = 'expenses';
        $button = '';
        if (auth()->guard('manager')->check()) {
            $button .= '<a href="' . route('manager.' . $route . '.edit', $this->id) . '" class="btn btn-icon btn-danger "><i class="la la-pencil"></i></a> ';
            $button .= '<button type="button" data-id="' . $this->id . '" data-toggle="modal" data-target="#deleteModel" class="deleteRecord btn btn-icon btn-danger"><i class="la la-trash"></i></button>';
        }else if (auth()->guard('accountant')->check()) {
//            $button .= '<a href="' . route('manager.' . $route . '.edit', $this->id) . '" class="btn btn-icon btn-danger disabled "><i class="la la-pencil"></i></a> ';
//            $button .= '<button disabled type="button" data-id="' . $this->id . '" data-toggle="modal" data-target="#deleteModel" class="deleteRecord btn btn-icon btn-danger"><i class="la la-trash"></i></button>';
        }
        return $button;
    }

}
