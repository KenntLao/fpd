<?php

namespace App\Http\Controllers;

use App\hris_employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\roles;
use App\hris_leaves;
use App\hris_leave_group_employees;
use App\hris_leave_rules;
use App\hris_leave_types;

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
            //$leave_type_name = hris_leaves::where('employee_id', $id)->leftJoin('hris_leave_types', 'hris_leaves.leave_type_id', '=', 'hris_leave_types.id')->get('name');
            return view('pages.leaveManagement.leaves.index', compact('leaves', 'role_ids', 'supervisor_id', 'self'));
        } else {
            $leaves = hris_leaves::where('employee_id', $id)->paginate(10);
           // $leave_type_name = hris_leaves::where('employee_id', $id)->leftJoin('hris_leave_types', 'hris_leaves.leave_type_id', '=', 'hris_leave_types.id')->get('name');
            return view('pages.leaveManagement.leaves.index', compact('leaves', 'role_ids', 'supervisor_id'));
        }
    }

    public function create(hris_leaves $leaves)
    {
        if($_SESSION['sys_account_mode'] == 'employee'){

            $id = $_SESSION['sys_id'];
            $employee = hris_employee::find($id);
            $emp_group = hris_leave_group_employees::where('employee_id', $id)->get();
            

            $leaveGroup_ids = hris_leave_group_employees::where('employee_id', $id)->get('leave_group_id');

            

            foreach ($leaveGroup_ids as $leaveGroup_id) {
                $lg_id = $leaveGroup_id->leave_group_id;
                $leave_groups_rules = hris_leave_rules::where('leave_group_id', $lg_id)->leftJoin('hris_leave_types', 'hris_leave_rules.leave_type_id', '=', 'hris_leave_types.id')->get();
            }

            if (!isset($leave_groups_rules)) {
                return redirect('/hris/pages/leaveManagement/leaves/index')->with('error', 'Add Employee to leave group');
            } else {
                return view('pages.leaveManagement.leaves.create', compact('employee', 'leaves', 'leave_groups_rules'));
            }

           
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

    public function edit(hris_leaves $leaves)
    {
        if ($_SESSION['sys_account_mode'] == 'employee') {

            $id = $_SESSION['sys_id'];
            $employee = hris_employee::find($id);
            $emp_group = hris_leave_group_employees::where('employee_id', $id)->get();


            $leaveGroup_ids = hris_leave_group_employees::where('employee_id', $id)->get('leave_group_id');

            foreach ($leaveGroup_ids as $leaveGroup_id) {
                $lg_id = $leaveGroup_id->leave_group_id;
                $leave_groups_rules = hris_leave_rules::where('leave_group_id', $lg_id)->leftJoin('hris_leave_types', 'hris_leave_rules.leave_type_id', '=', 'hris_leave_types.id')->get();
            }

            if (!isset($leave_groups_rules)) {
                return redirect('/hris/pages/leaveManagement/leaves/index')->with('error', 'Add Employee to leave group');
            } else {
                return view('pages.leaveManagement.leaves.edit', compact('employee', 'leaves', 'leave_groups_rules'));
            }
        } else {
            return view('pages.leaveManagement.leaves.edit');
        }
    }

    public function update(Request $request, hris_leaves $leaves)
    {
        if ($this->validatedData()) {
            $leaves->leave_type_id = $request->leave_type;
            $leaves->employee_id = $request->employee_id;
            $leaves->leave_start_date = date("Ymd", strtotime($request->start_date));
            $leaves->leave_end_date = date("Ymd", strtotime($request->end_date));
            $leaves->supervisor_id = $request->supervisor_id;
            $leaves->reason = $request->reason;
            $leaves->status = 0;
            $leaves->update();
            return redirect('/hris/pages/leaveManagement/leaves/index')->with('success', 'Leave Application submitted!');
        }
    }

    public function approve(hris_leaves $leaves)
    {
        $leave_type_id = $leaves->leave_type_id;
        $employee_id = $leaves->employee_id;
        $supervisor_id = $leaves->supervisor_id;
        $employee = hris_employee::where('id', $employee_id)->first();
        $leave_name = hris_leave_types::where('id',$leave_type_id)->first('name');
        $start_date = $leaves->leave_start_date;
        $end_date = $leaves->leave_end_date;
        $reason = $leaves->reason;

        return view('pages.leaveManagement.leaves.approve', compact('leaves','employee','leave_name','start_date','end_date','reason','leave_type_id','supervisor_id'));


    }
    public function approve_submit(Request $request, hris_leaves $leaves)
    {
        $id = $_SESSION['sys_id'];
        if($this->SupervisorValidatedData()){
            $leaves->approved_date = date("Ymd");
            $leaves->approved_by_id = $id;
            $leaves->remarks = $request->remarks;
            $leaves->status = 1;
            $leaves->update();
            return redirect('/hris/pages/leaveManagement/leaves/index')->with('success', 'Leave Application Approved!');
        }
    }

    public function deny(hris_leaves $leaves)
    {
        $leave_type_id = $leaves->leave_type_id;
        $employee_id = $leaves->employee_id;
        $supervisor_id = $leaves->supervisor_id;
        $employee = hris_employee::where('id', $employee_id)->first();
        $leave_name = hris_leave_types::where('id', $leave_type_id)->first('name');
        $start_date = $leaves->leave_start_date;
        $end_date = $leaves->leave_end_date;
        $reason = $leaves->reason;

        return view('pages.leaveManagement.leaves.deny', compact('leaves', 'employee', 'leave_name', 'start_date', 'end_date', 'reason', 'leave_type_id', 'supervisor_id'));
    }

    public function deny_submit(Request $request, hris_leaves $leaves)
    {
        $id = $_SESSION['sys_id'];
        if ($this->SupervisorValidatedData()) {
            $leaves->approved_date = date("Ymd");
            $leaves->approved_by_id = $id;
            $leaves->remarks = $request->remarks;
            $leaves->status = 2;
            $leaves->update();
            return redirect('/hris/pages/leaveManagement/leaves/index')->with('success', 'Leave Application Denied!');
        }
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
    protected function SupervisorValidatedData()
    {
        return request()->validate([
            'remarks' => 'required',
        ]);
    }
    
}
