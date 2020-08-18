<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OvertimeExport;
use App\hris_overtime;

class ExportController extends Controller
{
    public function overtimeExport()
    {
    	if ( $this->validatedData() ) {
    		$date_from = date(request('date_from'));
	    	$date_to = date(request('date_to'));
	    	$str_from = str_replace('-', '', request('date_from'));
	    	$str_to = str_replace('-', '', request('date_to'));
            if ( $_SESSION['sys_role_ids'] == ',1,' ) {
                $check = hris_overtime::all();
            } else {
                $check = hris_overtime::all()->where('supervisor_id', $_SESSION['sys_id'])->where('role_id', $_SESSION['sys_role_ids']);
            }
	    	if ( $check->isEmpty() ) {
	    		return back()->withErrors(['No data to download.']);
	    	} else {
	    		return Excel::download(new OvertimeExport($date_from,$date_to), 'FPD-OT-FROM-'. $str_from .'-TO-'. $str_to .'.xlsx');
	    	}
    	} else {
	    	return back()->withErrors($this->validatedData());
    	}
	}
    public function validatedData()
    {
    	return request()->validate([
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d|after:date_from',
    	]);
    }
    
}




