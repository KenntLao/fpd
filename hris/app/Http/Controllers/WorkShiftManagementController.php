<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_work_shift_management;

class WorkShiftManagementController extends Controller
{
    //
    public function index(hris_work_shift_management $work_shift){
        $work_shift = hris_work_shift_management::paginate(10);
        return view('pages.time.workshiftManagement.index', compact('work_shift'));
    }
    public function create(hris_work_shift_management $work_shift)
    {
        return view('pages.time.workshiftManagement.create', compact('work_shift'));
    }
    public function store(Request $request, hris_work_shift_management $work_shift){
        if($this->validatedData()){

            if(request('monday_shift') == NULL) {
                $monday_shift = 0;
            } else {
                $monday_shift = 1;
            }

            if (request('tuesday_shift') == NULL) {
                $tuesday_shift = 0;
            } else {
                $tuesday_shift = 1;
            }

            if (request('wednesday_shift') == NULL) {
                $wednesday_shift = 0;
            } else {
                $wednesday_shift = 1;
            }

            if (request('thursday_shift') == NULL) {
                $thursday_shift = 0;
            } else {
                $thursday_shift = 1;
            }

            if (request('friday_shift') == NULL) {
                $friday_shift = 0;
            } else {
                $friday_shift = 1;
            }

            if (request('saturday_shift') == NULL) {
                $saturday_shift = 0;
            } else {
                $saturday_shift = 1;
            }

            if (request('sunday_shift') == NULL) {
                $sunday_shift = 0;
            } else {
                $sunday_shift = 1;
            }

            $work_shift->workshift_name = request('workshift_name');
            $work_shift->monday_shift = $monday_shift;
            $work_shift->monday_time_in = strtotime(request('monday_time_in'));
            $work_shift->monday_time_out = strtotime(request('monday_time_out'));
            $work_shift->tuesday_shift = $tuesday_shift;
            $work_shift->tuesday_time_in = strtotime(request('tuesday_time_in'));
            $work_shift->tuesday_time_out = strtotime(request('tuesday_time_out'));
            $work_shift->wednesday_shift = $wednesday_shift;
            $work_shift->wednesday_time_in = strtotime(request('wednesday_time_in'));
            $work_shift->wednesday_time_out = strtotime(request('wednesday_time_out'));
            $work_shift->thursday_shift = $thursday_shift;
            $work_shift->thursday_time_in = strtotime(request('thursday_time_in'));
            $work_shift->thursday_time_out = strtotime(request('thursday_time_out'));
            $work_shift->friday_shift = $friday_shift;
            $work_shift->friday_time_in = strtotime(request('friday_time_in'));
            $work_shift->friday_time_out = strtotime(request('friday_time_out'));
            $work_shift->saturday_shift = $saturday_shift;
            $work_shift->saturday_time_in = strtotime(request('saturday_time_in'));
            $work_shift->saturday_time_out = strtotime(request('saturday_time_out'));
            $work_shift->sunday_shift = $sunday_shift;
            $work_shift->sunday_time_in = strtotime(request('sunday_time_in'));
            $work_shift->sunday_time_out = strtotime(request('sunday_time_out'));

            $work_shift->save();
            return redirect('/hris/pages/time/workshiftManagement/index')->with('success', 'Work Shift successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'workshift_name' => 'required',
            'monday_shift' => 'nullable',
            'monday_time_in' => 'nullable',
            'monday_time_out' => 'nullable',
            'tuesday_shift' => 'nullable',
            'tuesday_time_in' => 'nullable',
            'tuesday_time_out' => 'nullable',
            'wednesday_shift' => 'nullable',
            'wednesday_time_in' => 'nullable',
            'wednesday_time_out' => 'nullable',
            'thursday_shift' => 'nullable',
            'thursday_time_in' => 'nullable',
            'thursday_time_out' => 'nullable',
            'friday_shift' => 'nullable',
            'friday_time_in' => 'nullable',
            'friday_time_out' => 'nullable',
            'saturday_shift' => 'nullable',
            'saturday_time_in' => 'nullable',
            'saturday_time_out' => 'nullable',
            'sunday_shift' => 'nullable',
            'sunday_time_in' => 'nullable',
            'sunday_time_out' => 'nullable',
        ]);
    }
}
