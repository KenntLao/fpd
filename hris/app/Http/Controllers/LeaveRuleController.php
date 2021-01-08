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
        $leaveRules = hris_leave_rules::where('del_status', 0)->paginate(10);
        return view('pages.admin.leave.leaveRules.index', compact('leaveRules'));
    }

    public function create(hris_leave_rules $leaveRule)
    {
        $leaveTypes = hris_leave_types::all()->where('del_status', 0);
        $leaveGroups = hris_leave_groups::all()->where('del_status', 0);
        $leavePeriods = hris_leave_periods::all()->where('del_status', 0);
        $leaveRules = hris_job_titles::all()->where('del_status', 0);
        $employmentStatuses = hris_employment_statuses::all()->where('del_status', 0);
        $employees = hris_employee::all()->where('del_status', 0);
        $jobTitles = hris_job_titles::all()->where('del_status', 0);
        return view('pages.admin.leave.leaveRules.create', compact('leaveRule', 'leaveTypes', 'leaveGroups', 'leavePeriods', 'leaveRules', 'employmentStatuses', 'employees', 'jobTitles'));
    }

    public function store(hris_leave_rules $leaveRule, Request $request)
    {
        if ($this->validatedData()) {
            $leaveRule = hris_leave_rules::create($this->validatedData());
            $id = $leaveRule->id;
            $this->function->addSystemLog($this->module,$id);
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
        $leaveTypes = hris_leave_types::all()->where('del_status', 0);
        $leaveGroups = hris_leave_groups::all()->where('del_status', 0);
        $leavePeriods = hris_leave_periods::all()->where('del_status', 0);
        $leaveRules = hris_job_titles::all()->where('del_status', 0);
        $employmentStatuses = hris_employment_statuses::all()->where('del_status', 0);
        $employees = hris_employee::all()->where('del_status', 0);
        $jobTitles = hris_job_titles::all()->where('del_status', 0);
        return view('pages.admin.leave.leaveRules.edit', compact('leaveRule', 'leaveTypes', 'leaveGroups', 'leavePeriods', 'leaveRules', 'employmentStatuses', 'employees', 'jobTitles'));
    }

    public function update(hris_leave_rules $leaveRule, Request $request)
    {
        $id = $leaveRule->id;
        if ($this->validatedData()) {
            $string = 'App\hris_leave_rules';
            $leaveRule->leave_type_id = request('leave_type_id');
            $leaveRule->leave_group_id = request('leave_group_id');
            $leaveRule->employment_status_id = request('employment_status_id');
            $leaveRule->exp_days = request('exp_days');
            $leaveRule->leave_period_id = request('leave_period_id');
            $leaveRule->default_per_year = request('default_per_year');
            $leaveRule->supervisor_assign_leave = request('supervisor_assign_leave');
            $leaveRule->employee_can_apply = request('employee_can_apply');
            $leaveRule->apply_beyond_current = request('apply_beyond_current');
            $leaveRule->leave_accrue = request('leave_accrue');
            $leaveRule->proportionate_on_joined_date = request('proportionate_on_joined_date');
            $leaveRule->employee_leave_period = request('employee_leave_period');
            // GET CHANGES
            $changes = $leaveRule->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $leaveRule->update();
            // GET CHANGES
            $changed = $leaveRule->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $leaveRule->wasChanged() ) {
                return redirect('/hris/pages/admin/leave/leaveRules/index')->with('success', 'Leave rule successfully updated!');
            } else {
                return redirect('/hris/pages/admin/leave/leaveRules/index');
            } 
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_rules $leaveRule)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $leaveRule->del_status = 1;
                $leaveRule->update();
                $id = $leaveRule->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leaveRules/index')->with('success','Leave rule successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $leaveRule->del_status = 1;
                $leaveRule->update();
                $id = $leaveRule->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leaveRules/index')->with('success','Leave rule successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'leave_type_id' => 'required',
            'leave_group_id' => 'nullable',
            'employment_status_id' => 'nullable',
            'exp_days' => 'required',
            'leave_period_id' => 'nullable',
            'default_per_year' => 'required',
            'supervisor_assign_leave' => 'required',
            'employee_can_apply' => 'required',
            'apply_beyond_current' => 'required',
            'leave_accrue' => 'required',
            'proportionate_on_joined_date' => 'required',
            'employee_leave_period' => 'required',            
        ]);
    }

}
