<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_leave_groups;
use App\users;

class LeaveGroupController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Leave Settings - Leave Group';
    }
    public function index()
    {
        $leaveGroups = hris_leave_groups::paginate(10);
        return view('pages.admin.leave.leaveGroups.index', compact('leaveGroups'));
    }

    public function create(hris_leave_groups $leaveGroup)
    {
        return view('pages.admin.leave.leaveGroups.create', compact('leaveGroup'));
    }

    public function store(hris_leave_groups $leaveGroup, Request $request)
    {
        if ($this->validatedData()) {
            $leaveGroup = hris_leave_groups::create($this->validatedData());
            $id = $leaveGroup->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {

    }

    public function edit(hris_leave_groups $leaveGroup)
    {
        return view('pages.admin.leave.leaveGroups.edit', compact('leaveGroup'));
    }

    public function update(hris_leave_groups $leaveGroup, Request $request)
    {
        $id = $leaveGroup->id;
        if ($this->validatedData()) {
            $string = 'App\hris_leave_groups';
            $leaveGroup->name = request('name');
            $leaveGroup->details = request('details');
            // GET CHANGES
            $changes = $leaveGroup->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $leaveGroup->update();
            // GET CHANGES
            $changed = $leaveGroup->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $leaveGroup->wasChanged() ) {
                return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully updated!');
            } else {
                return redirect('/hris/pages/admin/leave/leaveGroups/index');
            }

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_groups $leaveGroup)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveGroup->delete();
            $id = $leaveGroup->id;
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'details' => 'nullable'
        ]);
    }
}
