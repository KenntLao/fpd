<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_group_employees;
use App\hris_leave_groups;
use App\users;
use App\hris_employee;
use App\hris_leave_entitlement;
use App\hris_leave_rules;

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
        if ($this->validatedData()) {
            $data = [];
            $entitlement_data = [];
            $employee_ids = $request->employee_id;
            $leave_rules = hris_leave_rules::where('leave_group_id',$request->leave_group_id)->get();
            foreach($employee_ids as $employee_id){
                foreach($leave_rules as $leave_rule){
                    $insert_entitlement = ['leave_type_id'=>$leave_rule->leave_type_id, 'leave_group_id'=>$request->leave_group_id,'leave_credit'=>$leave_rule->default_per_year,'employee_id'=>$employee_id];
                    array_push($entitlement_data,$insert_entitlement);
                }
                $insert_data = ['employee_id'=>$employee_id, 'leave_group_id'=>$request->leave_group_id];
                array_push($data,$insert_data);
            }
            $leaveEntitlement = hris_leave_entitlement::insert($entitlement_data);
            $leaveGroupEmployees = hris_leave_group_employees::insert($data);
            $id = $leaveGroupEmployee->id;
            $this->function->addSystemLog($this->module,$id);
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
        $id = $leaveGroupEmployee->id;
        if ($this->validatedData()) {
            $string = 'App\hris_leave_group_employees';
            $data = [];
            $employee_ids = $request->employee_id;
            foreach ($employee_ids as $employee_id) {
                $leaveGroupEmployee->employee_id =  $employee_id;
                $leaveGroupEmployee->leave_group_id = request('leave_group_id');
                $leaveGroupEmployee->update();
            }

            // GET CHANGES
            $changes = $leaveGroupEmployee->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            
            // GET CHANGES
            $changed = $leaveGroupEmployee->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $leaveGroupEmployee->wasChanged() ) {
                return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully updated!');
            } else {
                return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_group_employees $leaveGroupEmployee)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $leaveGroupEmployee->delete();
                $id = $leaveGroupEmployee->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $leaveGroupEmployee->delete();
                $id = $leaveGroupEmployee->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
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
