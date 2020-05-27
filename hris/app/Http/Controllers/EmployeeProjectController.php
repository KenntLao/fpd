<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employee_projects;
use App\hris_projects;

class EmployeeProjectController extends Controller
{

    public function index()
    {
        $employeeProjects = hris_employee_projects::paginate(10);
        return view('pages.admin.properties.employeeProjects.index', compact('employeeProjects'));
    }

    public function create(hris_employee_projects $employeeProject)
    {
        $projects = hris_projects::all();
        return view('pages.admin.properties.employeeProjects.create', compact('employeeProject','projects'));
    }


    public function store(Request $request)
    {
        $employeeProject = new hris_employee_projects();
        if($this->validatedData()) {
            $employeeProject->employee = request('employee');
            $employeeProject->project = request('project');
            $employeeProject->details = request('details');
            $employeeProject->save();
            return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully deleted!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_projects $employeeProject)
    {
        $projects = hris_projects::all();
        return view('pages.admin.properties.employeeProjects.edit', compact('employeeProject', 'projects'));
    }

    public function update(hris_employee_projects $employeeProject, Request $request)
    {
        if($this->validatedData()) {
            $employeeProject->employee = request('employee');
            $employeeProject->project = request('project');
            $employeeProject->details = request('details');
            $employeeProject->update();
            return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_projects $employeeProject)
    {
        $employeeProject->delete();
        return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully deleted');
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee' => 'required',
            'project' => 'required'
        ]);
    }

}
