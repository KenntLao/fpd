<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_expenses extends Model
{
    protected $guarded = [];

    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

    public function payment_method()
    {
    	return $this->belongsTo('App\hris_payment_methods');
    }

}
