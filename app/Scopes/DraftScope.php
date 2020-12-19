<?php
/*
Dev Omar Shaheen
Devomar095@gmail.com
WhatsApp +972592554320
*/

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class DraftScope implements Scope
{

    public function apply(Builder $builder, Model $model)
    {
        $builder->where('draft', '=', 0);
    }
}
