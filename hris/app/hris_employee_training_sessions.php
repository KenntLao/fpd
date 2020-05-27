<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_training_sessions extends Model
{
	protected $guarded = [];

	public function training() 
	{
		return $this->belongsTo('App\hris_training_sessions');
	}

}
