<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_workshift_assignment;
use App\hris_work_shift_management;
use App\hris_employee;
use App\users;
use App\Notifications\WorkShiftNotif;

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
        return view('pages.time.workshiftAssignment.index', compact('workshift_assignment'));
    }
    public function create(hris_workshift_assignment $workshift_assignment, hris_employee $employees, hris_work_shift_management $work_shift)
    {
        $employees = hris_employee::all();
        $work_shift = hris_work_shift_management::all();
        return view('pages.time.workshiftAssignment.create', compact('workshift_assignment', 'employees', 'work_shift'));
    }
    public function store(Request $request, hris_workshift_assignment $workshift_assignment)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $workshift_assignment->employee_id = $request->employee_id;
            $workshift_assignment->workshift_id = $request->workshift_id;
            $workshift_assignment->date_from = date('Ymd', strtotime($request->date_from));
            $workshift_assignment->date_to = date('Ymd', strtotime($request->date_to));
            $workshift_assignment->status = 0;
            $workshift_assignment->save();

            $id = $workshift_assignment->id;
            $this->function->addSystemLog($this->module,$action,$id);


            // WORKSHIFT NOTIFICATION
            $employee_req = $request->employee_id;
            $employee = hris_employee::find($_SESSION['sys_id']);
            $employee_receiver = hris_employee::find($employee_req);
            $employee_receiver->notify(new WorkShiftNotif($employee));

            
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
            $string = 'App\hris_workshift_assignment';
            $workshift_assignment->employee_id = $request->employee_id;
            $workshift_assignment->workshift_id = $request->workshift_id;
            $workshift_assignment->date_from = date('Ymd', strtotime($request->date_from));
            $workshift_assignment->date_to = date('Ymd', strtotime($request->date_to));
            $workshift_assignment->status = 0;

            //DO systemLog function FROM SystemLogController
            // GET CHANGES
            $changes = $workshift_assignment->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module, $string, $changes, $id);
            $workshift_assignment->update();
            // GET CHANGES
            $changed = $workshift_assignment->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module, $changed, $string, $id);
            if ($workshift_assignment->wasChanged()) {
                return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
            } else {
                return redirect('/hris/pages/time/workshiftAssignment/index');
            }
            
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function destroy(hris_workshift_assignment $workshift_assignment)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if (Hash::check(request('upass'), $employee->password)) {
            $workshift_assignment->delete();
            $id = $workshift_assignment->id;
            $this->function->deleteSystemLog($this->module, $id);
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
