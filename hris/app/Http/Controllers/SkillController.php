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
        $action = 'add';
        if($this->validatedData()) {
            $skill = hris_skills::create($this->validatedData());
            $id = $skill->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $skill;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $skill->update($this->validatedData());
            return redirect('/hris/pages/admin/qualifications/skills/index')->with('success', 'Skill successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_skills $skill)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $skill->delete();
            $id = $skill->id;
            $this->function->systemLog($this->module,$action,$id);
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
