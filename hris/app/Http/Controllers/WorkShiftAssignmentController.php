<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $id = $workshift_assignment->id;
            //$this->function->systemLog($this->module,$action,$id);
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
