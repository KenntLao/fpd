<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_job_functions;
use App\users;

class JobFunctionController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Recruitment Setup - Job  Function';
    }
    public function index()
    {   
        $jobFunctions = hris_job_functions::paginate(10);
        return view('pages.recruitment.recruitmentSetup.jobFunctions.index', compact('jobFunctions'));
    }

    public function create(hris_job_functions $jobFunction)
    {
        return view('pages.recruitment.recruitmentSetup.jobFunctions.create', compact('jobFunction'));
    }

    public function store(hris_job_functions $jobFunction, Request $request)
    {
        if ($this->validatedData()) {
            $jobFunction = hris_job_functions::create($this->validatedData());
            $id = $jobFunction->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success', 'Job function successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {
  
    }

    public function edit(hris_job_functions $jobFunction)
    {
        return view('pages.recruitment.recruitmentSetup.jobFunctions.edit', compact('jobFunction'));
    }

    public function update(hris_job_functions $jobFunction, Request $request)
    {
        $id = $jobFunction->id;
        if ($this->validatedData()) {
            $string = 'App\hris_job_functions';
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($this->module,$string,$id);
            $jobFunction->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success', 'Job function successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }  
    }

    public function destroy(hris_job_functions $jobFunction)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $jobFunction->delete();
            $id = $jobFunction->id;
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success','Job function successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}