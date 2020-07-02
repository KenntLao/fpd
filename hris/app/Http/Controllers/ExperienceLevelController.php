<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_experience_levels;
use App\users;

class ExperienceLevelController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Recruitment Setup - Experience Level';
    }

    public function index()
    {   
        $experienceLevels = hris_experience_levels::paginate(10);
        return view('pages.recruitment.recruitmentSetup.experienceLevels.index', compact('experienceLevels'));
    }

    public function create(hris_experience_levels $experienceLevel)
    {
        return view('pages.recruitment.recruitmentSetup.experienceLevels.create', compact('experienceLevel'));
    }

    public function store(hris_experience_levels $experienceLevel, Request $request)
    {
        if ($this->validatedData()) {
            $experienceLevel = hris_experience_levels::create($this->validatedData());
            $id = $experienceLevel->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/experienceLevels/index')->with('success', 'Experience level added!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {
        //
    }

    public function edit(hris_experience_levels $experienceLevel)
    {
        return view('pages.recruitment.recruitmentSetup.experienceLevels.edit', compact('experienceLevel'));
    }

    public function update(hris_experience_levels $experienceLevel, Request $request)
    {
        $id = $experienceLevel->id;
        if ($this->validatedData()) {
            $string = 'App\hris_experience_levels';
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($this->module,$string,$id);
            $experienceLevel->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/experienceLevels/index')->with('success', 'Experience level updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_experience_levels $experienceLevel)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $experienceLevel->delete();
            $id = $experienceLevel->id;
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/experienceLevels/index')->with('success','Experience level deleted!');
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