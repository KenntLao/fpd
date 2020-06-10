<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_paid_time_offs extends Model
{
    protected $guarded = [];

    public function leave_type()
    {
    	return $this->belongsTo('App\hris_leave_types');
    }
    public function leave_period()
    {
    	return $this->belongsTo('App\hris_leave_periods');
    }
    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

}
