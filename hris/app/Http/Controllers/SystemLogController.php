<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_system_logs;

class SystemLogController extends Controller
{
	public function index() 
	{
        $logs = hris_system_logs::orderBy('created_at','desc')->paginate(30);
		return view('pages.admin.auditLog.index', compact('logs'));
	}
}
