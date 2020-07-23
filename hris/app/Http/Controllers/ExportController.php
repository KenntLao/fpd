<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OvertimeExport;

class ExportController extends Controller
{
    public function overtimeExport()
    {
    	return Excel::download(new OvertimeExport, 'overtime.xlsx');
    }
}
