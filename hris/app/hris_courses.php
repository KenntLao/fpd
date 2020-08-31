<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_courses extends Model
{
	protected $guarded = [];

	public function coordinator() {

		return $this->belongsTo('App\hris_employee');

	}

}
