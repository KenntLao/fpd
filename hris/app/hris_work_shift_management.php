<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_work_shift_management extends Model
{
    //
    protected $guarded = [];

    public function getWorkShiftAssignmentRelation()
    {
        return $this->hasOne('App\hris_workshift_assignment', 'workshift_id', 'id');
    }
}
