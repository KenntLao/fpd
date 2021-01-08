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
        $jobFunctions = hris_job_functions::where('del_status', 0)->paginate(10);
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
            $jobFunction->name = request('name');
            // GET CHANGES
            $changes = $jobFunction->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $jobFunction->update();
            // GET CHANGES
            $changed = $jobFunction->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $jobFunction->wasChanged() ) {
                return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success', 'Job function successfully updated!');
            } else {
                return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }  
    }

    public function destroy(hris_job_functions $jobFunction)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $jobFunction->del_status = 1;
                $jobFunction->update();
                $id = $jobFunction->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success','Job function successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $jobFunction->del_status = 1;
                $jobFunction->update();
                $id = $jobFunction->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success','Job function successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}