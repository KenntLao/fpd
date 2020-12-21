<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_prf extends Model
{
    //
    protected $table = 'hris_prf';

    public function employee()
    {
        return $this->belongsTo('App\hris_employee');
    }
    public function department()
    {
        return $this->belongsTo('App\hris_company_structures');
    }

    public function employmentStatus(){
        return $this->belongsTo('App\hris_employment_statuses');
    }

    public function jobTitle(){
        return $this->belongsTo('App\hris_job_titles');
    }
}
