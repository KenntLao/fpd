<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_leaves extends Model
{
    protected $guarded = [];

    public function leave_types()
    {
        return $this->belongsTo('App\hris_leave_types');
    }
}
