<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_itinerary_requests extends Model
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
    public function currency()
    {
    	return $this->belongsTo('App\hris_currencies');
    }
    public function department()
    {
        return $this->belongsTo('App\hris_company_structures');
    }

}
