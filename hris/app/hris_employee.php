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

    public function department(){
        return $this->belongsTo('App\hris_company_structures');
    }

    public function job_title(){
        return $this->belongsTo('App\hris_job_titles');
    }

    public function roles(){
        return $this->belongsTo('App\roles','id');
    }

}