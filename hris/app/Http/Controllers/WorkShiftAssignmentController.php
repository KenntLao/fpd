<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_workshift_assignment;
use App\hris_work_shift_management;
use App\hris_employee;

class WorkShiftAssignmentController extends Controller
{
    //
    public function index(hris_workshift_assignment $workshift_assignment)
    {
        $workshift_assignment = hris_workshift_assignment::paginate(10);

        $employee = hris_employee::join('hris_workshift_assignments', 'hris_workshift_assignments.employee_id', '=', 'hris_employees.id')->get();
        $workshift = hris_work_shift_management::join('hris_workshift_assignments', 'hris_workshift_assignments.workshift_id', '=', 'hris_work_shift_managements.id')->get();
        return view('pages.time.workshiftAssignment.index', compact('workshift_assignment', 'employee', 'workshift'));
    }
    public function create(hris_workshift_assignment $workshift_assignment, hris_employee $employees, hris_work_shift_management $work_shift)
    {
        $employees = hris_employee::all();
        $work_shift = hris_work_shift_management::all();
        return view('pages.time.workshiftAssignment.create', compact('workshift_assignment', 'employees', 'work_shift'));
    }
    public function store()
    {
        if ($this->validatedData()) {
            hris_workshift_assignment::create($this->validatedData());
            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'workshift_id' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
    }
}
