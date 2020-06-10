<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_leave_rules extends Model
{
    protected $guarded = [];

    public function leave_group() 
    {
    	return $this->belongsTo('App\hris_leave_groups');
    }
    public function leave_type() 
    {
    	return $this->belongsTo('App\hris_leave_types');
    }
    public function leave_period() 
    {
    	return $this->belongsTo('App\hris_leave_periods');
    }
    public function job_title() 
    {
    	return $this->belongsTo('App\hris_job_titles');
    }
    public function employment_status() 
    {
    	return $this->belongsTo('App\hris_employment_statuses');
    }
    public function employee() 
    {
    	return $this->belongsTo('App\hris_employee');
    }
    public function department() 
    {
    	return $this->belongsTo('App\hris_company_structures');
    }

}
