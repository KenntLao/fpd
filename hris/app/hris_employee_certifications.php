<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_certifications extends Model
{
    protected $guarded = [];

    public function certification()
    {
    	return $this->belongsTo('App\hris_certifications');
    }

    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

}
