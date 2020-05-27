<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_skills;

class SkillController extends Controller
{

    public function index()
    {
        $skills = hris_skills::paginate(10);
        return view('pages.admin.qualifications.skills.index', compact('skills'));
    }

    public function create(hris_skills $skill)
    {
        return view('pages.admin.qualifications.skills.create', compact('skill'));
    }

    public function store(Request $request)
    {
        $skill = new hris_skills();

        if($this->validatedData()) {
            $skill->name = request('name');
            $skill->description = request('description');
            $skill->save();
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
        if($this->validatedData()) {
            $skill->name = request('name');
            $skill->description = request('description');
            $skill->update();
            return redirect('/hris/pages/admin/qualifications/skills/index')->with('success', 'Skill successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_skills $skill)
    {
        $skill->delete();
        return redirect('/hris/pages/admin/qualifications/skills/index')->with('success', 'Skill successfully deleted!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    }
}
