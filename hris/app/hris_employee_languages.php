<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_languages extends Model
{
    protected $guarded = [];

    public function language()
    {
    	return $this->belongsTo('App\hris_languages');
    }

}
