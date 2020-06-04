<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_training_sessions extends Model
{
	protected $guarded = [];

	public function training_session()
	{
		return $this->belongsTo('App\hris_training_sessions');
	}
	public function employee()
	{
		return $this->belongsTo('App\hris_employee');
	}
}
