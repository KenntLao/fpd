<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_leave_groups extends Model
{
    protected $guarded = [];

    public function job_title()
    {
        return $this->belongsTo('App\hris_job_titles');
    }
}
