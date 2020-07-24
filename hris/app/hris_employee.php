<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class hris_employee extends Model
{
    use Notifiable;
    //
    protected $guarded = [];

    public function getEmployeeWorkShiftAssignmentRelation(){
        return $this->hasOne('App\hris_workshift_assignment', 'employee_id', 'id');
    }

    public function department(){
        return $this->belongsTo('App\hris_company_structures');
    }

    public function job_title(){
        return $this->belongsTo('App\hris_job_titles','job_title_id','id');
    }

    public function roles(){
        return $this->belongsTo('App\roles','id');
    }
    public function employeeProject(){
        return $this->belongsTo('App\hris_employee_projects', 'id','employee_id');
    }
}