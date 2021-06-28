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
        $jobTitles = hris_job_titles::where('del_status', 0)->get();
        return view('pages.admin.jobDetails.jobTitles.index', compact('jobTitles'));
    }

    public function create(hris_job_titles $jobTitle)
    {
        return view('pages.admin.jobDetails.jobTitles.create', compact('jobTitle'));
    }


    public function store(hris_job_titles $jobTitle, Request $request)
    {
        if ($this->validatedData()) {
            $jobTitle = hris_job_titles::create($this->validatedData());
            $id = $jobTitle->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_job_titles';
            $jobTitle->code = request('code');
            $jobTitle->name = request('name');
            $jobTitle->description = request('description');
            $jobTitle->specification = request('specification');
            $jobTitle->job_grade = request('job_grade');
            // GET CHANGES
            $changes = $jobTitle->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $jobTitle->update();
            // GET CHANGES
            $changed = $jobTitle->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $jobTitle->wasChanged() ) {
                return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully updated!');
            } else {
                return redirect('/hris/pages/admin/jobDetails/jobTitles/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_job_titles $jobTitle)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $jobTitle->del_status = 1;
                $jobTitle->update();
                $id = $jobTitle->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $jobTitle->del_status = 1;
                $jobTitle->update();
                $id = $jobTitle->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData() {

        return request()->validate([
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'specification' => 'required',
            'job_grade' => 'required'
        ]);

    }

}
