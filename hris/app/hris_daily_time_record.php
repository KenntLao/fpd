<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_daily_time_record extends Model
{
    //
    public function employeeAttendance(){
        $this->belongsTo('App\hris_attendances');
    }
}
