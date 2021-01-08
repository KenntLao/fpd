<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_work_weeks;
use App\hris_countries;
use App\users;

class WorkWeekController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Leave Settings - Work Week';
    }
    public function index()
    {
        $workWeeks = hris_work_weeks::where('del_status', 0)->paginate(10);
        return view('pages.admin.leave.workWeeks.index', compact('workWeeks'));
    }

    public function create(hris_work_weeks $workWeek)
    {
        $countries = hris_countries::all()->where('del_status', 0);
        return view('pages.admin.leave.workWeeks.create', compact('workWeek', 'countries'));
    }

    public function store(hris_work_weeks $workWeek, Request $request)
    {
        if($this->validatedData()) {
            $workWeek = hris_work_weeks::create($this->validatedData());
            $id = $workWeek->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_work_weeks $workWeek)
    {
        $countries = hris_countries::all()->where('del_status', 0);
        return view('pages.admin.leave.workWeeks.edit', compact('workWeek', 'countries'));
    }

    public function update(hris_work_weeks $workWeek, Request $request)
    {
        $id = $workWeek->id;
        if($this->validatedData()) {
            $string = 'App\hris_work_weeks';
            $workWeek->day = request('day');
            $workWeek->status = request('status');
            $workWeek->country = request('country');
            // GET CHANGES
            $changes = $workWeek->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $workWeek->update();
            // GET CHANGES
            $changed = $workWeek->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $workWeek->wasChanged() ) {
                return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully updated!');
            } else {
                return redirect('/hris/pages/admin/leave/workWeeks/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_work_weeks $workWeek)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $workWeek->del_status = 1;
                $workWeek->update();
                $id = $workWeek->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $workWeek->del_status = 1;
                $workWeek->update();
                $id = $workWeek->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'day' => 'required',
            'status' => 'required',
            'country' => 'nullable',
        ]);
    }

}
