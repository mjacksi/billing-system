<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;use Illuminate\Database\Eloquent\Model;


class BillFiles extends Model
{
    protected $table = 'bill_files';
    protected $guarded = [];

    public function getFileAttribute($value)
    {
        return is_null($value) ? null : asset($value);
    }
}
