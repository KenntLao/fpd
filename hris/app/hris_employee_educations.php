<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_educations extends Model
{
    protected $guarded = [];

    public function education()
    {
    	return $this->belongsTo('App\hris_educations');
    }

    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

}
