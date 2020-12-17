<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_npa extends Model
{
	protected $guarded = [];

	public function employee()
	{
		return $this->belongsTo('App\hris_employee');
	}

	public function sender()
	{
		return $this->belongsTo('App\hris_employee');
	}

	public function project()
	{
		return $this->belongsTo('App\hris_projects');
	}

	public function designation_from()
	{
		return $this->belongsTo('App\hris_projects');
	}

	public function designation_to()
	{
		return $this->belongsTo('App\hris_projects');
	}

	public function process()
	{
		return $this->belongsTo('App\hris_employee');
	}

	public function approve()
	{
		return $this->belongsTo('App\hris_employee');
	}


}
