<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_leave_group_employees extends Model
{
    protected $guarded = [];

    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

    public function leave_group()
    {
    	return $this->belongsTo('App\hris_leave_groups');
    }

}
