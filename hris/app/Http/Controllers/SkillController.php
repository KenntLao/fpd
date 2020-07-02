<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_skills;
use App\users;

class SkillController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Qualifications Setup - Skill';
    }
    public function index()
    {
        $skills = hris_skills::paginate(10);
        return view('pages.admin.qualifications.skills.index', compact('skills'));
    }

    public function create(hris_skills $skill)
    {
        return view('pages.admin.qualifications.skills.create', compact('skill'));
    }

    public function store(hris_skills $skill, Request $request)
    {
        if($this->validatedData()) {
            $skill = hris_skills::create($this->validatedData());
            $id = $skill->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/qualifications/skills/index')->with('success', 'Skill successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_skills $skill)
    {
        return view('pages.admin.qualifications.skills.edit', compact('skill'));
    }

    public function update(hris_skills $skill, Request $request)
    {
        $id = $skill->id;
        if($this->validatedData()) {
            $string = 'App\hris_skills';
            $skill->name = request('name');
            $skill->description = request('description');
            // GET CHANGES
            $changes = $skill->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $skill->update();
            // GET CHANGES
            $changed = $skill->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $skill->wasChanged() ) {
                return redirect('/hris/pages/admin/qualifications/skills/index')->with('success', 'Skill successfully updated!');
            } else {
                return redirect('/hris/pages/admin/qualifications/skills/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_skills $skill)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $skill->delete();
            $id = $skill->id;
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/qualifications/skills/index')->with('success', 'Skill successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    }
}
