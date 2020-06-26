<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_overtime extends Model
{
    protected $guarded = [];

    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }
    public function supervisor()
    {
    	return $this->belongsTo('App\hris_employee');
    }
    public function department()
    {
    	return $this->belongsTo('App\hris_company_structures');
    }

}
