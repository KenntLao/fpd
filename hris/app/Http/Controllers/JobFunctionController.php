<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_job_functions;

class JobFunctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $jobFunctions = hris_job_functions::paginate(10);
        return view('pages.recruitment.recruitmentSetup.jobFunctions.index', compact('jobFunctions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(hris_job_functions $jobFunction)
    {
        return view('pages.recruitment.recruitmentSetup.jobFunctions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $jobFunction = new hris_job_functions();

        if ($this->validatedData()) {
            $jobFunction->name = request('name');
            $jobFunction->save();
            return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success', 'Job function successfully added!');
        } else {
            return back()->withErrors($this->validatedData);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(hris_job_functions $jobFunction)
    {
        return view('pages.recruitment.recruitmentSetup.jobFunctions.edit', compact('jobFunction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(hris_job_functions $jobFunction, Request $request)
    {
        if ($this->validatedData()) {
            $jobFunction->name = request('name');
            $jobFunction->update();
            return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success', 'Job function successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        }  
    }

    public function destroy(hris_job_functions $jobFunction)
    {
        $jobFunction->delete();
        return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success','Job function successfully deleted!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}