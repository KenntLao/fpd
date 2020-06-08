<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_skills extends Model
{
    protected $guarded = [];

    public function skill()
    {
    	return $this->belongsTo('App\hris_skills');
    }

}
