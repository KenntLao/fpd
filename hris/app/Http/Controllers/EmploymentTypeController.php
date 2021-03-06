<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employment_types;
use App\users;

class EmploymentTypeController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Recruitment Setup - Employment Type';
    }
    public function index()
    {
        $employmentTypes = hris_employment_types::paginate(10);
        return view('pages.recruitment.recruitmentSetup.employmentTypes.index', compact('employmentTypes'));
    }

    public function create(hris_employment_types $employmentType)
    {
        return view('pages.recruitment.recruitmentSetup.employmentTypes.create', compact('employmentType'));
    }

    public function store(hris_employment_types $employmentType, Request $request)
    {
        if ($this->validatedData()) {
            $employmentType = hris_employment_types::create($this->validatedData());
            $id = $employmentType->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success', 'Employment type successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $employmentType = hris_employment_types::find($id);
        return view('pages.recruitment.recruitmentSetup.employmentTypes.edit', compact('employmentType'));
    }

    public function update(hris_employment_types $employmentType, Request $request)
    {
        $id = $employmentType->id;
        if ($this->validatedData()) {
            $string = 'App\hris_employment_types';
            $employmentType->name = request('name');
            // GET CHANGES
            $changes = $employmentType->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employmentType->update();
            // GET CHANGES
            $changed = $employmentType->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employmentType->wasChanged() ) {
                return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success', 'Employment type successfully updated!');
            } else {
                return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        } 
    }

    public function destroy(hris_employment_types $employmentType)
    {   
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $employmentType->delete();
                $id = $employmentType->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success','Employment type successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $employmentType->delete();
                $id = $employmentType->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success','Employment type successfully deleted!');
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
