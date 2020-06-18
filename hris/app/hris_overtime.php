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

}
