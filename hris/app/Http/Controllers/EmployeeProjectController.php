<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employee_projects;
use App\hris_projects;
use App\users;
use App\hris_employee;

class EmployeeProjectController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Properties Setup - Employee Project';
    }

    public function index()
    {
        $employeeProjects = hris_employee_projects::where('del_status', 0)->paginate(10);
        return view('pages.admin.properties.employeeProjects.index', compact('employeeProjects'));
    }

    public function create(hris_employee_projects $employeeProject)
    {
        $projects = hris_projects::where('del_status', 0)->get();
        $employees = hris_employee::where('del_status', 0)->get();
        return view('pages.admin.properties.employeeProjects.create', compact('employeeProject','projects', 'employees'));
    }


    public function store(hris_employee_projects $employeeProject, Request $request)
    {
        if($this->validatedData()) {
            $employeeProject = hris_employee_projects::create($this->validatedData());
            $id = $employeeProject->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee project successfully deleted!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_projects $employeeProject)
    {
        $projects = hris_projects::where('del_status', 0)->get();
        $employees = hris_employee::where('del_status', 0)->get();
        return view('pages.admin.properties.employeeProjects.edit', compact('employeeProject', 'projects', 'employees'));
    }

    public function update(hris_employee_projects $employeeProject, Request $request)
    {
        $id = $employeeProject->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee_projects';
            $employeeProject->employee_id = request('employee_id');
            $employeeProject->project_id = request('project_id');
            $employeeProject->details = request('details');
            // GET CHANGES
            $changes = $employeeProject->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employeeProject->update();
            // GET CHANGES
            $changed = $employeeProject->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employeeProject->wasChanged() ) {
                return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully updated!');
            } else {
                return redirect('/hris/pages/admin/properties/employeeProjects/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_projects $employeeProject)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $employeeProject->del_status = 1;
                $employeeProject->update();
                $id = $employeeProject->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully deleted');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $employeeProject->del_status = 1;
                $employeeProject->update();
                $id = $employeeProject->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully deleted');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'project_id' => 'required',
            'details' => 'nullable'
        ]);
    }

}
