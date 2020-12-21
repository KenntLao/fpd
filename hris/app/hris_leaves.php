<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_leaves extends Model
{
    protected $guarded = [];

    public function leave_types()
    {
        return $this->belongsTo('App\hris_leave_types','leave_type_id','id');
    }
    public function supervisor()
    {
        return $this->belongsTo('App\hris_employee', 'approved_by_id','id');
    }
    public function employee()
    {
        return $this->belongsTo('App\hris_employee');
    }
}
