<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_overtime_requests extends Model
{
	protected $guarded = [];

	public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

    public function category()
    {
    	return $this->belongsTo('App\hris_overtime_categories');
    }

    public function project()
    {
    	return $this->belongsTo('App\hris_projects');
    }

}
