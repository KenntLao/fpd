<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_workshift_assignment;
use App\hris_work_shift_management;
use App\hris_employee;
use App\users;

class WorkShiftAssignmentController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Time Management - Work Shift Assignment';
    }

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
    public function store(hris_workshift_assignment $workshift_assignment)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $workshift_assignment = hris_workshift_assignment::create($this->validatedData());
            $id = $workshift_assignment->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function edit(hris_workshift_assignment $workshift_assignment, hris_employee $employees, hris_work_shift_management $work_shift){
        $employees = hris_employee::all();
        $employee = hris_employee::with('getEmployeeWorkShiftAssignmentRelation')->first();
        $work_shift = hris_work_shift_management::all();
        $workshift_rel = hris_work_shift_management::with('getWorkShiftAssignmentRelation')->first();
        return view('pages.time.workshiftAssignment.edit', compact('workshift_assignment','employee','workshift_rel','employees', 'work_shift'));
    }
    public function update(Request $request, hris_workshift_assignment $workshift_assignment){
        $id = $workshift_assignment->id;
        if ($this->validatedData()) {
            $model = $workshift_assignment;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $workshift_assignment->update($this->validatedData());
            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function destroy(hris_workshift_assignment $workshift_assignment)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ($upass == request('upass')) {
            $workshift_assignment->delete();
            $id = $benefit->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
