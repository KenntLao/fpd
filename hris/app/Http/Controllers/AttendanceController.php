<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_attendances;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = hris_attendances::paginate(10);
        return view('pages.time.attendances.index', compact('attendances'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $attendance = new hris_attendances();
        $attendance->time_in = date_create();
        $attendance->save();
        return redirect('/hris/pages/time/attendances/index')->with('success', 'Punch in successful!');
    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

}
