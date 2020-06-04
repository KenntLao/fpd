<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_projects extends Model
{
    protected $guarded = [];

    public function client()
    {
    	return $this->belongsTo('App\hris_clients');
    }

}
