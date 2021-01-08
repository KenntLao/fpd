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
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Personal Information - Skill';
    }
    public function index()
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $employeeSkills = hris_employee_skills::where('del_status', 0)->paginate(10);
            return view('pages.personalInformation.skills.index', compact('employeeSkills'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function create(hris_employee_skills $employeeSkill)
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $skills = hris_skills::where('del_status', 0)->get();
            return view('pages.personalInformation.skills.create', compact('employeeSkill', 'skills'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function store(hris_employee_skills $employeeSkill, Request $request)
    {
        $employee_id = $_SESSION['sys_id'];
        if ($this->validatedData()) {
            $employeeSkill->employee_id = $employee_id;
            $employeeSkill->skill_id = request('skill_id');
            $employeeSkill->details = request('details');
            $employeeSkill->save();
            $id = $employeeSkill->id;
            $this->function->addSystemLog($this->module,$id);
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
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $skills = hris_skills::where('del_status', 0)->get();
            return view('pages.personalInformation.skills.edit', compact('employeeSkill', 'skills'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function update(hris_employee_skills $employeeSkill, Request $request)
    {
        $id = $employeeSkill->id;
        if ($this->validatedData()) {
            $string = 'App\hris_employee_skills';
            $employeeSkill->skill_id = request('skill_id');
            $employeeSkill->details = request('details');
            // GET CHANGES
            $changes = $employeeSkill->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employeeSkill->update();
            // GET CHANGES
            $changed = $employeeSkill->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employeeSkill->wasChanged() ) {
                return redirect('/hris/pages/personalInformation/skills/index')->with('success', 'Employee skill successfully updated!');
            } else {
                return redirect('/hris/pages/personalInformation/skills/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_skills $employeeSkill)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            return back()->with(['You do not have access in this page.']);
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('password'), $employee->password) ) {
                $employeeSkill->del_status = 1;
                $employeeSkill->update();
                $id = $employeeSkill->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/personalInformation/skills/index')->with('success', 'Employee skill successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
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
