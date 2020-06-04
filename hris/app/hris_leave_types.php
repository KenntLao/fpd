<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_leave_types extends Model
{
	protected $guarded = [];

	public function leave_group()
	{
		return $this->belongsTo('App\hris_leave_groups');
	}

}
