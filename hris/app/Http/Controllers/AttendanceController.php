<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_attendances;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendance = hris_attendances::orderBy('id','desc')->first();
        $attendances = hris_attendances::paginate(10);
        return view('pages.time.attendances.index', compact('attendances','attendance'));
    }

    public function store(Request $request, hris_attendances $attendance)
    {
        if($this->validatedData()){
            // check data if valid
            $img = request('time_in_photo');
            $folderPath = public_path('assets/images/employees/employee_time_in/');
            $image_parts = explode(";base64,", $img);
            $image_base64 = base64_decode($image_parts[1]);
            $file_name = uniqid() . '.png';
            
            $attendance->time_in_photo = $file_name;
            $attendance->time_in = time();
            $attendance->status = 1;

            $attendance->save();

            file_put_contents($folderPath . $file_name, $image_base64);
            return redirect('/hris/pages/time/attendances/index')->with('success', 'Punch in successful!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function punchout(Request $request, hris_attendances $attendance){
        dd($attendance->id);
        $attendance->time_out = time();
        $attendance->status = request('status');
        $attendance->update();
    }

    public function show($id)
    {

    }



    protected function validatedData(){
        return request()->validate([
            'time_in_photo' => 'required',
        ]);
    }
}
