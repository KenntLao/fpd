<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_job_positions extends Model
{
    protected $guarded = [];

    public function benefit()
    {
    	return $this->belongsTo('App\hris_benefits');
    }
    public function employment_type()
    {
    	return $this->belongsTo('App\hris_employment_types');
    }
    public function education_level()
    {
        return $this->belongsTo('App\hris_education_levels');
    }
    public function exp_level()
    {
        return $this->belongsTo('App\hris_experience_levels');
    }
    public function job_function()
    {
        return $this->belongsTo('App\hris_job_function');
    }
    public function department()
    {
        return $this->belongsTo('App\hris_company_structures');
    }


}
