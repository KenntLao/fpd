<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class hris_company_assets extends Model
{
    protected $guarded = [];

    public function asset_type()
    {
    	return $this->belongsTo('App\hris_company_asset_types');
    }
    public function employee()
    {
    	return $this->belongsTo('App\hris_employee');
    }
    public function department()
    {
    	return $this->belongsTo('App\hris_company_structures');
    }

}
