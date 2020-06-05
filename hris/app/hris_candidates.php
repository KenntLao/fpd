<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_candidates extends Model
{
    protected $guarded = [];

    public function job_position()
    {
    	return $this->belongsTo('App\hris_job_positions');
    }

}
