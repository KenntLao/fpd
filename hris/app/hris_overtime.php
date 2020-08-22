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
    public function approved_by()
    {
        return $this->belongsTo('App\hris_employee');
    }
    public function sender()
    {
        return $this->belongsTo('App\hris_employee');
    }
    public function department()
    {
    	return $this->belongsTo('App\hris_company_structures');
    }
    public function overtime_category()
    {
        return $this->belongsTo('App\hris_overtime_categories');
    }
    public function overtime_type()
    {
        return $this->belongsTo('App\hris_overtime_types');
    }
}



