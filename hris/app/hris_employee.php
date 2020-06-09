<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee extends Model
{
    //
    protected $guarded = [];

    public function getEmployeeWorkShiftAssignmentRelation(){
        return $this->hasOne('App\hris_workshift_assignment', 'employee_id', 'id');
    }
}