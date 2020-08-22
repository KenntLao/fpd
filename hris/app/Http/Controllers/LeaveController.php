<?php

namespace App\Http\Controllers;

use App\hris_employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\hris_leaves;
use App\hris_leave_group_employees;
use App\hris_leave_rules;

class LeaveController extends Controller
{
    public function index()
    {
        $id = $_SESSION['sys_id'];
        $roles = roles::all();
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $find = hris_employee::find($id);
        $role_ids = explode(',', $find->role_id);

        if (in_array($supervisor_id, $role_ids)) {
            $department = $find->department_id;
            $employee = hris_employee::all()->where('department_id', $department)->where('supervisor', $id);
            $employee_id = array();
            foreach ($employee as $e) {
                $employee_id[] = $e->id;
            }
            $leaves = hris_leaves::whereIn('employee_id', $employee_id)->paginate(10);
            $self = hris_leaves::where('employee_id', $id)->paginate(10);
            return view('pages.leaveManagement.leaves.index', compact('leaves', 'role_ids', 'supervisor_id', 'self'));
        } else {
            $leaves = hris_leaves::where('employee_id', $id)->paginate(10);
            return view('pages.leaveManagement.leaves.index', compact('leaves', 'role_ids', 'supervisor_id'));
        }
    }

    public function create(hris_leaves $leaves)
    {
        if($_SESSION['sys_account_mode'] == 'employee'){
            $id = $_SESSION['sys_id'];
            $employee = hris_employee::find($id);

            $leaveGroup_ids = hris_leave_group_employees::where('employee_id', $id)->get('leave_group_id');

            foreach ($leaveGroup_ids as $leaveGroup_id) {
                $lg_id = $leaveGroup_id->leave_group_id;
                $leave_groups_rules = hris_leave_rules::where('leave_group_id', $lg_id)->leftJoin('hris_leave_types', 'hris_leave_rules.leave_type_id', '=', 'hris_leave_types.id')->get();
            }

            return view('pages.leaveManagement.leaves.create', compact('employee','leaves', 'leave_groups_rules'));
        } else {
            return view('pages.leaveManagement.leaves.create');
        }
    }

    public function store(hris_leaves $leaves, Request $request)
    {
        if($this->validatedData()){
            $leaves->leave_type_id = $request->leave_type;
            $leaves->employee_id = $request->employee_id;
            $leaves->leave_start_date = date("Ymd", strtotime($request->start_date));
            $leaves->leave_end_date = date("Ymd", strtotime($request->end_date));
            $leaves->supervisor_id = $request->supervisor_id;
            $leaves->reason = $request->reason;
            $leaves->status = 0;
            $leaves->save();
            return redirect('/hris/pages/leaveManagement/leaves/index')->with('success', 'Leave Application submitted!');
        }

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

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'supervisor_id' => 'required',
            'leave_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);
    }
    
}
