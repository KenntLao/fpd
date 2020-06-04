<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_training_sessions extends Model
{
	protected $guarded = [];

	public function course()
	{
		return $this->belongsTo('App\hris_courses');
	}

}
