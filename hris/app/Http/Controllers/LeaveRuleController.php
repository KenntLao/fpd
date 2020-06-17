<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\users;
use App\hris_leave_rules;
use App\hris_leave_types;
use App\hris_leave_groups;
use App\hris_leave_periods;
use App\hris_job_titles;
use App\hris_employment_statuses;
use App\hris_employee;
use App\hris_company_structures;

class LeaveRuleController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Leave Settings - Leave Rule';
    }
    public function index()
    {
        $leaveRules = hris_leave_rules::paginate(10);
        return view('pages.admin.leave.leaveRules.index', compact('leaveRules'));
    }

    public function create(hris_leave_rules $leaveRule)
    {
        $leaveTypes = hris_leave_types::all();
        $leaveGroups = hris_leave_groups::all();
        $leavePeriods = hris_leave_periods::all();
        $leaveRules = hris_job_titles::all();
        $employmentStatuses = hris_employment_statuses::all();
        $employees = hris_employee::all();
        $departments = hris_company_structures::all();
        return view('pages.admin.leave.leaveRules.create', compact('leaveRule', 'leaveTypes', 'leaveGroups', 'leavePeriods', 'leaveRules', 'employmentStatuses', 'employees', 'departments'));
    }

    public function store(hris_leave_rules $leaveRule, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $leaveRule = hris_leave_rules::create($this->validatedData());
            $id = $leaveRule->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveRules/index')->with('success', 'Leave rule successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_rules $leaveRule)
    {
        $leaveTypes = hris_leave_types::all();
        $leaveGroups = hris_leave_groups::all();
        $leavePeriods = hris_leave_periods::all();
        $leaveRules = hris_job_titles::all();
        $employmentStatuses = hris_employment_statuses::all();
        $employees = hris_employee::all();
        $departments = hris_company_structures::all();
        return view('pages.admin.leave.leaveRules.edit', compact('leaveRule', 'leaveTypes', 'leaveGroups', 'leavePeriods', 'leaveRules', 'employmentStatuses', 'employees', 'departments'));
    }

    public function update(hris_leave_rules $leaveRule, Request $request)
    {
        $id = $leaveRule->id;
        if ($this->validatedData()) {
            $model = $leaveRule;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $leaveRule->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/leaveRules/index')->with('success', 'Leave rule successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_rules $leaveRule)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveRule->delete();
            $id = $leaveRule->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveRules/index')->with('success','Leave rule successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'leave_type_id' => 'required',
            'leave_group_id' => 'nullable',
            'job_title_id' => 'nullable',
            'employment_status_id' => 'nullable',
            'employee_id' => 'nullable',
            'exp_days' => 'required',
            'department_id' => 'nullable',
            'leave_period_id' => 'nullable',
            'default_per_year' => 'required',
            'supervisor_assign_leave' => 'required',
            'employee_can_apply' => 'required',
            'apply_beyond_current' => 'required',
            'leave_accrue' => 'required',
            'carried_forward' => 'required',
            'carried_forward_percentage' => 'required',
            'max_carried_forward_amount' => 'required',
            'carried_forward_leave_availability' => 'required',
            'proportionate_on_joined_date' => 'required',
            'employee_leave_period' => 'required',            
        ]);
    }

}
