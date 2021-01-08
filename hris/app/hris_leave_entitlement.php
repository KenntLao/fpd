<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_leave_entitlement extends Model
{
    //
    public function leave_type()
    {
        return $this->belongsTo('App\hris_leave_types');
    }

}
