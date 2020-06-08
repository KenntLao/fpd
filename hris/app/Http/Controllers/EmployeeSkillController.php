<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_skills;
use App\hris_employee_skills;
use App\hris_employee;

class EmployeeSkillController extends Controller
{
    public function index()
    {
        $employeeSkills = hris_employee_skills::paginate(10);
        return view('pages.personalInformation.skills.index', compact('employeeSkills'));
    }

    public function create(hris_employee_skills $employeeSkill)
    {
        $skills = hris_skills::all();
        return view('pages.personalInformation.skills.create', compact('employeeSkill', 'skills'));
    }

    public function store(hris_employee_skills $employeeSkill, Request $request)
    {
        $employee_id = $_SESSION['sys_id'];
        if ($this->validatedData()) {
            $employeeSkill->employee_id = $employee_id;
            $employeeSkill->skill_id = request('skill_id');
            $employeeSkill->details = request('details');
            $employeeSkill->save();
            return redirect('/hris/pages/personalInformation/skills/index')->with('success', 'Employee skill successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(hris_employee_skills $employeeSkill)
    {
        $skills = hris_skills::all();
        return view('pages.personalInformation.skills.edit', compact('employeeSkill', 'skills'));
    }

    public function update(hris_employee_skills $employeeSkill, Request $request)
    {
        $employee_id = $_SESSION['sys_id'];
        if ($this->validatedData()) {
            $employeeSkill->employee_id = $employee_id;
            $employeeSkill->skill_id = request('skill_id');
            $employeeSkill->details = request('details');
            $employeeSkill->update();
            return redirect('/hris/pages/personalInformation/skills/index')->with('success', 'Employee skill successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_skills $employeeSkill)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if ( Hash::check(request('password'), $employee->password) ) {
            $employeeSkill->delete();
            return redirect('/hris/pages/personalInformation/skills/index')->with('success', 'Employee skill successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'skill_id' => 'required',
            'details' => 'required'
        ]);
    }
}
