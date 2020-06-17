<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_job_titles;
use App\users;

class JobTitleController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Job Details Setup - Job Title';
    }
    public function index()
    {   
        $jobTitles = hris_job_titles::paginate(10);
        return view('pages.admin.jobDetails.jobTitles.index', compact('jobTitles'));
    }

    public function create(hris_job_titles $jobTitle)
    {
        return view('pages.admin.jobDetails.jobTitles.create', compact('jobTitle'));
    }


    public function store(hris_job_titles $jobTitle, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $jobTitle = hris_job_titles::create($this->validatedData());
            $id = $jobTitle->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {

    }

    public function edit(hris_job_titles $jobTitle)
    {
        return view('pages.admin.jobDetails.jobTitles.edit', compact('jobTitle'));
    }

    public function update(hris_job_titles $jobTitle, Request $request)
    {
        $id = $jobTitle->id;
        if($this->validatedData()) {
            $model = $jobTitle;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $jobTitle->update($this->validatedData());
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_job_titles $jobTitle)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $jobTitle->delete();
            $id = $jobTitle->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() {

        return request()->validate([
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'specification' => 'required'
        ]);

    }

}
