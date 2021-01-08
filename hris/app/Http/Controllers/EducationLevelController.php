<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_education_levels;
use App\users;

class EducationLevelController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Recruitment Setup - Education Level';
    }
    public function index()
    {   
        $educationLevels = hris_education_levels::where('del_status', 0)->paginate(10);
        return view('pages.recruitment.recruitmentSetup.educationLevels.index', compact('educationLevels'));
    }

    public function create(hris_education_levels $educationLevel)
    {
        return view('pages.recruitment.recruitmentSetup.educationLevels.create', compact('educationLevel'));
    }

    public function store(hris_education_levels $educationLevel, Request $request)
    {
        if ($this->validatedData()) {
            $educationLevel = hris_education_levels::create($this->validatedData());
            $id = $educationLevel->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(hris_education_levels $educationLevel)
    {
        return view('pages.recruitment.recruitmentSetup.educationLevels.edit', compact('educationLevel'));
    }

    public function update(hris_education_levels $educationLevel, Request $request)
    {
        $id = $educationLevel->id;
        if ($this->validatedData()) {
            $string = 'App\hris_education_levels';
            $educationLevel->name = request('name');
            // GET CHANGES
            $changes = $educationLevel->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $educationLevel->update();
            // GET CHANGES
            $changed = $educationLevel->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $educationLevel->wasChanged() ) {
                return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully updated!');
            } else {
                return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        } 
    }

    public function destroy(hris_education_levels $educationLevel)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $educationLevel->del_status = 1;
                $educationLevel->update();
                $id = $educationLevel->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success','Education level successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $educationLevel->del_status = 1;
                $educationLevel->update();
                $id = $educationLevel->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success','Education level successfully deleted!');
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
