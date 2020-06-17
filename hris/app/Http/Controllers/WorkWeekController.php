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
        $workWeeks = hris_work_weeks::paginate(10);
        return view('pages.admin.leave.workWeeks.index', compact('workWeeks'));
    }

    public function create(hris_work_weeks $workWeek)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.workWeeks.create', compact('workWeek', 'countries'));
    }

    public function store(hris_work_weeks $workWeek, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $workWeek = hris_work_weeks::create($this->validatedData());
            $id = $workWeek->id;
            $this->function->systemLog($this->module,$action,$id);
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
        $countries = hris_countries::all();
        return view('pages.admin.leave.workWeeks.edit', compact('workWeek', 'countries'));
    }

    public function update(hris_work_weeks $workWeek, Request $request)
    {
        $id = $workWeek->id;
        if($this->validatedData()) {
            $model = $workWeek;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $workWeek->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_work_weeks $workWeek)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $workWeek->delete();
            $id = $workWeek->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
