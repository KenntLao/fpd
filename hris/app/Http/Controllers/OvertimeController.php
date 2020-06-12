<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_overtime;

class OvertimeController extends Controller
{
    //
    public function index(hris_overtime $overtimes)
    {
        $overtimes = hris_overtime::paginate(10);
        return view('pages.time.overtime.index', compact('overtimes'));
    }
}
