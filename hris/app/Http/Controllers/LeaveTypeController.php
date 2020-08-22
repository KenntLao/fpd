<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_groups;
use App\hris_leave_types;
use App\users;

class LeaveTypeController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Leave Settings - Leave Type';
    }
    public function index()
    {
        $leaveTypes = hris_leave_types::paginate(10);
        return view('pages.admin.leave.leaveTypes.index', compact('leaveTypes'));
    }

    public function create(hris_leave_types $leaveType)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveTypes.create', compact('leaveType', 'leaveGroups'));
    }

    public function store(hris_leave_types $leaveType, Request $request)
    {
        if($this->validatedData()) {
            $leaveType = hris_leave_types::create($this->validatedData());
            $id = $leaveType->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_types $leaveType)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveTypes.edit', compact('leaveType', 'leaveGroups'));
    }

    public function update(hris_leave_types $leaveType, Request $request)
    {
        $id = $leaveType->id;
        if($this->validatedData()) {
            $string = 'App\hris_leave_types';
            $leaveType->name = request('name');
            $leaveType->leave_color = request('leave_color');
            // GET CHANGES
            $changes = $leaveType->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $leaveType->update();
            // GET CHANGES
            $changed = $leaveType->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $leaveType->wasChanged() ) {
                return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully updated!');
            } else {
                return redirect('/hris/pages/admin/leave/leaveTypes/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_types $leaveType)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $leaveType->delete();
                $id = $leaveType->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }

        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $leaveType->delete();
                $id = $leaveType->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'leave_color' => 'required'
        ]);
    }

}
