<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\users;
use App\hris_paid_time_offs;
use App\hris_leave_types;
use App\hris_leave_periods;
use App\hris_employee;

class PaidTimeOffController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Leave Settings - Paid Time Off';
    }
    public function index()
    {
        $paidTimeOffs = hris_paid_time_offs::where('del_status', 0)->paginate(10);
        return view('pages.admin.leave.paidTimeOffs.index', compact('paidTimeOffs'));
    }

    public function create(hris_paid_time_offs $paidTimeOff)
    {
        $leaveTypes = hris_leave_types::all()->where('del_status', 0);
        $leavePeriods = hris_leave_periods::all()->where('del_status', 0);
        $employees = hris_employee::all()->where('del_status', 0);
        return view('pages.admin.leave.paidTimeOffs.create', compact('paidTimeOff', 'leaveTypes', 'leavePeriods', 'employees'));
    }

    public function store(hris_paid_time_offs $paidTimeOff, Request $request)
    {
        if ($this->validatedData()) {
            $paidTimeOff = hris_paid_time_offs::create($this->validatedData());
            $id = $paidTimeOff->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success', 'Paid time off successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_paid_time_offs $paidTimeOff)
    {
        $leaveTypes = hris_leave_types::all()->where('del_status', 0);
        $leavePeriods = hris_leave_periods::all()->where('del_status', 0);
        $employees = hris_employee::all()->where('del_status', 0);
        return view('pages.admin.leave.paidTimeOffs.edit', compact('paidTimeOff', 'leaveTypes', 'leavePeriods', 'employees'));
    }

    public function update(hris_paid_time_offs $paidTimeOff, Request $request)
    {
        $id = $paidTimeOff->id;
        if ($this->validatedData()) {
            $string = 'App\hris_paid_time_offs';
            $paidTimeOff->leave_type_id = request('leave_type_id');
            $paidTimeOff->employee_id = request('employee_id');
            $paidTimeOff->leave_period_id = request('leave_period_id');
            $paidTimeOff->amount = request('amount');
            $paidTimeOff->note = request('note');
            // GET CHANGES
            $changes = $paidTimeOff->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $paidTimeOff->update();
            // GET CHANGES
            $changed = $paidTimeOff->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $paidTimeOff->wasChanged() ) {
                return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success', 'Paid time off successfully updated!');
            } else {
                return redirect('/hris/pages/admin/leave/paidTimeOffs/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_paid_time_offs $paidTimeOff)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $paidTimeOff->del_status = 1;
                $paidTimeOff->update();
                $id = $paidTimeOff->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success','Paid time off successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $paidTimeOff->del_status = 1;
                $paidTimeOff->update();
                $id = $paidTimeOff->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success','Paid time off successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'leave_type_id' => 'required',
            'employee_id' => 'required',
            'leave_period_id' => 'required',
            'amount' => 'required',
            'note' => 'nullable'
        ]);
    }

}
