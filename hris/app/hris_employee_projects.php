<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_projects extends Model
{
	
	protected $guarded = [];

	public function employee() 
	{
		return $this->belongsTo('App\hris_employee','employee_id','employee_number');
	}

	public function project()
	{
		return $this->belongsTo('App\hris_projects');
	}

}
