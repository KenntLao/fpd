<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_company_documents extends Model
{
    //
    protected $guarded = [];

    public function department()
    {
    	return $this->belongsTo('App\hris_department');
    }
    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

}
