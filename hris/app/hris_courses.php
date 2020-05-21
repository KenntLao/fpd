<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_courses extends Model
{
	protected $guarded = [];

	public function status()
	{
		return $this->hasMany('App\hris_training_sessions');
	}

}
