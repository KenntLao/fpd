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
        $educationLevels = hris_education_levels::paginate(10);
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
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($this->module,$string,$id);
            $educationLevel->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        } 
    }

    public function destroy(hris_education_levels $educationLevel)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $educationLevel->delete();
            $id = $educationLevel->id;
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success','Education level successfully deleted!');
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
