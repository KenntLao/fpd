<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_candidate_logs extends Model
{
    protected $guarded = [];
    protected $table = 'table_candidate_logs';

    public function hr()
    {
        return $this->belongsTo('App\hris_employee','hr_id');
    }
    public function manager()
    {
        return $this->belongsTo('App\hris_employee', 'manager_id');
    }

    public function candidate(){
        return $this->belongsTo('App\hris_candidates', 'candidate_id');
    }
}
