<?php

namespace App\Http\Controllers;

use App\hris_job_titles;
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
        $leaveGroups = hris_leave_groups::where('del_status', 0)->paginate(10);
        
        return view('pages.admin.leave.leaveGroups.index', compact('leaveGroups'));
    }

    public function create(hris_leave_groups $leaveGroup)
    {
        $job_titles = hris_job_titles::all()->where('del_status', 0);
        $job_title_ids = explode(',',$leaveGroup->job_title_id);
        return view('pages.admin.leave.leaveGroups.create', compact('leaveGroup', 'job_titles', 'job_title_ids'));
    }

    public function store(hris_leave_groups $leaveGroup, Request $request)
    {
        if ($this->validatedData()) {

            $job_title_ids = implode(',',request('job_title'));

            $leaveGroup->name = request('name');
            $leaveGroup->job_title_id = ','.$job_title_ids.',';
            $leaveGroup->details = request('details');
            $leaveGroup->del_status = 0;
            $leaveGroup->save();

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
        $job_titles = hris_job_titles::all()->where('del_status', 0);
        $job_title_ids = explode(',', $leaveGroup->job_title_id);
        return view('pages.admin.leave.leaveGroups.edit', compact('leaveGroup','job_titles', 'job_title_ids'));
    }

    public function update(hris_leave_groups $leaveGroup, Request $request)
    {
        $id = $leaveGroup->id;
        if ($this->validatedData()) {
            $string = 'App\hris_leave_groups';

            $job_title_ids = implode(',', request('job_title'));

            $leaveGroup->name = request('name');
            $leaveGroup->job_title_id = ',' . $job_title_ids . ',';
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
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $leaveGroup->del_status = 1;
                $leaveGroup->update();
                $id = $leaveGroup->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $leaveGroup->del_status = 1;
                $leaveGroup->update();
                $id = $leaveGroup->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'job_title' => 'required',
            'details' => 'nullable'
        ]);
    }
}
