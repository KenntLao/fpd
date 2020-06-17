<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employment_statuses;
use App\users;

class EmploymentStatusController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Job Details Setup - Employment Status';
    }
    public function index()
    {
        $employmentStatuses = hris_employment_statuses::paginate(10);
        return view('pages.admin.jobDetails.employmentStatuses.index', compact('employmentStatuses'));
    }

    public function create(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.create', compact('employmentStatus'));
    }

    public function store(hris_employment_statuses $employmentStatus, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $employmentStatus = hris_employment_statuses::create($this->validatedData());
            $id = $employmentStatus->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment status successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.edit', compact('employmentStatus'));
    }

    public function update(hris_employment_statuses $employmentStatus ,Request $request)
    {
        $id = $employmentStatus->id;
        if($this->validatedData()) {
            $model = $employmentStatus;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $employmentStatus->update($this->validatedData());
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment status successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employment_statuses $employmentStatus)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employmentStatus->delete();
            $id = $employmentStatus->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment status successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'

        ]);

    }

}
