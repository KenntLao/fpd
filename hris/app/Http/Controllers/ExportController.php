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
    	$check = hris_overtime::all()->where('supervisor_id', $_SESSION['sys_id'])->where('role_id', $_SESSION['sys_role_ids']);
    	if ( $check->isEmpty() ) {
    		return back()->withErrors(['No data to download.']);
    	} else {
    		return Excel::download(new OvertimeExport, 'overtime.xlsx');
    	}
    }
}
