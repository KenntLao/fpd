<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_functions extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo('App\hris_courses');
    }

    public function client()
    {
        return $this->belongsTo('App\hris_clients');
    }

    public function project()
    {
        return $this->belongsTo('App\hris_projects');
    }

    public function skill()
    {
    	return $this->belongsTo('App\hris_skills');
    }

    public function employee()
    {
    	return $this->belongsTo('App\hris_employees');
    }

    public function department()
    {
    	return $this->belongsTo('App\hris_company_structures');
    }

    public function leave_type()
    {
        return $this->belongsTo('App\hris_leave_types');
    }

    public function leave_period()
    {
        return $this->belongsTo('App\hris_leave_periods');
    }

    public function leave_group()
    {
        return $this->belongsTo('App\hris_leave_groups');
    }

    public function payment_method()
    {
        return $this->belongsTo('App\hris_payment_methods');
    }

    public function expense_category()
    {
        return $this->belongsTo('App\hris_expenses_categories');
    }

    public function loan_type()
    {
        return $this->belongsTo('App\hris_company_loan_types');
    }

    public function asset_type()
    {
        return $this->belongsTo('App\hris_company_asset_types');
    }

    public function currency()
    {
        return $this->belongsTo('App\hris_currencies');
    }

    public function job_function()
    {
        return $this->belongsTo('App\hris_job_functions');
    }

    public function job_position()
    {
        return $this->belongsTo('App\hris_job_positions');
    }

    public function benefit()
    {
        return $this->belongsTo('App\hris_benefits');
    }

    public function education_level()
    {
        return $this->belongsTo('App\hris_education_levels');
    }

    public function employment_type()
    {
        return $this->belongsTo('App\hris_employment_type');
    }

    public function exp_level()
    {
        return $this->belongsTo('App\hris_experience_levels');
    }

    public function candidate()
    {
        return $this->belongsTo('App\hris_candidates');
    }

}
