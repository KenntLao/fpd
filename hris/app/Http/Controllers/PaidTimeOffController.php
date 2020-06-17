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
        $paidTimeOffs = hris_paid_time_offs::paginate(10);
        return view('pages.admin.leave.paidTimeOffs.index', compact('paidTimeOffs'));
    }

    public function create(hris_paid_time_offs $paidTimeOff)
    {
        $leaveTypes = hris_leave_types::all();
        $leavePeriods = hris_leave_periods::all();
        $employees = hris_employee::all();
        return view('pages.admin.leave.paidTimeOffs.create', compact('paidTimeOff', 'leaveTypes', 'leavePeriods', 'employees'));
    }

    public function store(hris_paid_time_offs $paidTimeOff, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $paidTimeOff = hris_paid_time_offs::create($this->validatedData());
            $id = $paidTimeOff->id;
            $this->function->systemLog($this->module,$action,$id);
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
        $leaveTypes = hris_leave_types::all();
        $leavePeriods = hris_leave_periods::all();
        $employees = hris_employee::all();
        return view('pages.admin.leave.paidTimeOffs.edit', compact('paidTimeOff', 'leaveTypes', 'leavePeriods', 'employees'));
    }

    public function update(hris_paid_time_offs $paidTimeOff, Request $request)
    {
        $id = $paidTimeOff->id;
        if ($this->validatedData()) {
            $model = $paidTimeOff;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $paidTimeOff->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success', 'Paid time off successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_paid_time_offs $paidTimeOff)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $paidTimeOff->delete();
            $id = $paidTimeOff->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success','Paid time off successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
