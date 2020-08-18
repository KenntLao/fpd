<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_workshift_assignment extends Model
{
    //
    protected $guarded = [];

    public function employee(){
        return $this->belongsTo('App\hris_employee','employee_id', 'id');
    }
    public function workshift(){
        return $this->belongsTo('App\hris_work_shift_management');
    }

}
