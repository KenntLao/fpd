<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OvertimeExport;
use App\hris_overtime;
use App\hris_employee;
use App\roles;

class ExportController extends Controller
{
    public function overtimeExport()
    {
    	if ( $this->validatedData() ) {
    		$date_from = date(request('date_from'));
	    	$date_to = date(request('date_to'));
	    	$str_from = str_replace('-', '', request('date_from'));
	    	$str_to = str_replace('-', '', request('date_to'));
            $employee_id = request('employee_id');
            $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
            $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
            $roles = explode(',', $_SESSION['sys_role_ids']);
            if ( $employee_id == '0' ) {
                $emp_name = 'ALL';
            } else {
                $employee = hris_employee::find($employee_id);
                $emp_name = $employee->firstname.'_'.$employee->lastname;
            }
            $type = request('type');
            if ( $_SESSION['sys_role_ids'] == ',1,'  OR in_array($hr_officer_id, $roles) ) {
                $check = hris_overtime::all();
            } else {
                $check = hris_overtime::all()->where('supervisor_id', $_SESSION['sys_id'])->where('role_id', $_SESSION['sys_role_ids']);
            }
            if ( $check->isEmpty() ) {
                return back()->withErrors(['No data to download.']);
            } else {
                return Excel::download(new OvertimeExport($date_from,$date_to,$employee_id,$type), 'FPD-OT-FROM-'. $str_from .'-TO-'. $str_to .'-TYPE-'. $type .'-'. $emp_name .'.xlsx');
            }
    	} else {
	    	return back()->withErrors($this->validatedData());
    	}
	}
    public function validatedData()
    {
    	return request()->validate([
            'date_from' => 'required|date_format:Y-m-d',
            'date_to' => 'required|date_format:Y-m-d|after:date from',
    	]);
    }
    
}
