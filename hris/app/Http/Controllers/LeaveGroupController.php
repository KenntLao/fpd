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
        $action = 'add';
        if ($this->validatedData()) {
            $leaveGroup = hris_leave_groups::create($this->validatedData());
            $id = $leaveGroup->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $leaveGroup;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $leaveGroup->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully updated!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_groups $leaveGroup)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveGroup->delete();
            $id = $leaveGroup->id;
            $this->function->systemLog($this->module,$action,$id);
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
