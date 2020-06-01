<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_job_titles;

class JobTitleController extends Controller
{
    public function index()
    {   
        $jobTitles = hris_job_titles::paginate(10);
        return view('pages.admin.jobDetails.jobTitles.index', compact('jobTitles'));
    }

    public function create(hris_job_titles $jobTitle)
    {
        return view('pages.admin.jobDetails.jobTitles.create', compact('jobTitle'));
    }


    public function store(Request $request)
    {

        $jobTitle = new hris_job_titles();
        if ($this->validatedData()) {
            $jobTitle->code = request('code');
            $jobTitle->name = request('name');
            $jobTitle->description = request('description');
            $jobTitle->specification = request('specification');
            $jobTitle->save();
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job Title successfully added!');
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
        if($this->validatedData()) {
            $jobTitle->code = request('code');
            $jobTitle->name = request('name');
            $jobTitle->description = request('description');
            $jobTitle->specification = request('specification');
            $jobTitle->update();
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job Title successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_job_titles $jobTitle)
    {
        $jobTitle->delete();
        return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job Title successfully deleted!');
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
