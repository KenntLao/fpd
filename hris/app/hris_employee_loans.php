<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_loans extends Model
{
	protected $guarded = [];

	public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

	public function type()
    {
    	return $this->belongsTo('App\hris_company_loan_types');
    }
}
