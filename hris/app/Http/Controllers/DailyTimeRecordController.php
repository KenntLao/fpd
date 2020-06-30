<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_daily_time_record;

class DailyTimeRecordController extends Controller
{
    //
    public function index(){
        
        return view('pages.time.dailyTimeRecords.index');
    }
}
