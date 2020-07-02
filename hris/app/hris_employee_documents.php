<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_employee_documents extends Model
{
    protected $guarded = [];

    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }

    public function document_type()
    {
    	return $this->belongsTo('App\hris_document_types');
    }

}
