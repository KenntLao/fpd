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
        if($this->validatedData()) {
            $leavePeriod = hris_leave_periods::create($this->validatedData());
            $id = $leavePeriod->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_leave_periods';
            $leavePeriod->name = request('name');
            $leavePeriod->start = request('start');
            $leavePeriod->end = request('end');
            // GET CHANGES
            $changes = $leavePeriod->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $leavePeriod->update();
            // GET CHANGES
            $changed = $leavePeriod->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $leavePeriod->wasChanged() ) {
                return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully updated!');
            } else {
                return redirect('/hris/pages/admin/leave/leavePeriods/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_periods $leavePeriod)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $leavePeriod->delete();
                $id = $leavePeriod->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $leavePeriod->delete();
                $id = $asset->id;
                $this->leavePeriod->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'start' => 'required|before:end',
            'end' => 'required|after:start'
        ]);
    }

}
