<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_periods;
use App\users;

class LeavePeriodController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Leave Settings - Leave Period';
    }
    public function index()
    {
        $leavePeriods = hris_leave_periods::paginate(10);
        return view('pages.admin.leave.leavePeriods.index', compact('leavePeriods'));
    }

    public function create(hris_leave_periods $leavePeriod)
    {
        return view('pages.admin.leave.leavePeriods.create', compact('leavePeriod'));
    }

    public function store(hris_leave_periods $leavePeriod, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $leavePeriod = hris_leave_periods::create($this->validatedData());
            $id = $leavePeriod->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_periods $leavePeriod)
    {
        return view('pages.admin.leave.leavePeriods.edit', compact('leavePeriod'));
    }

    public function update(hris_leave_periods $leavePeriod, Request $request)
    {
        $id = $leavePeriod->id;
        if($this->validatedData()) {
            $model = $leavePeriod;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $leavePeriod->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_periods $leavePeriod)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leavePeriod->delete();
            $id = $leavePeriod->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);
    }

}
