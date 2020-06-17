<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_group_employees;
use App\hris_leave_groups;
use App\users;
use App\hris_employee;

class LeaveGroupEmployeeController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Leave Settings - Leave Group Employee';
    }
    public function index()
    {
        $leaveGroupEmployees = hris_leave_group_employees::paginate(10);
        return view('pages.admin.leave.leaveGroupEmployees.index', compact('leaveGroupEmployees'));
    }

    public function create(hris_leave_group_employees $leaveGroupEmployee)
    {
        $leaveGroups = hris_leave_groups::all();
        $employees = hris_employee::all();
        return view('pages.admin.leave.leaveGroupEmployees.create', compact('leaveGroupEmployee', 'leaveGroups', 'employees'));
    }

    public function store(hris_leave_group_employees $leaveGroupEmployee, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $leaveGroupEmployee = hris_leave_group_employees::create($this->validatedData());
            $id = $jobTitle->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_group_employees $leaveGroupEmployee)
    {
        $leaveGroups = hris_leave_groups::all();
        $employees = hris_employee::all();
        return view('pages.admin.leave.leaveGroupEmployees.edit', compact('leaveGroupEmployee', 'leaveGroups', 'employees'));
    }

    public function update(hris_leave_group_employees $leaveGroupEmployee, Request $request)
    {
        $id = $jobTitle->id;
        if ($this->validatedData()) {
            $model = $jobTitle;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $leaveGroupEmployee->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_group_employees $leaveGroupEmployee)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveGroupEmployee->delete();
            $id = $jobTitle->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'leave_group_id' => 'required'
        ]);
    }

}
