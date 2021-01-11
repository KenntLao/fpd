<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_employee_educations;
use App\hris_employee;
use App\hris_educations;


class EmployeeEducationController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Personal Information - Education';
    }
    public function index()
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $employeeEducations = hris_employee_educations::where('del_status', 0)->paginate(10);
            return view('pages.personalInformation.educations.index', compact('employeeEducations'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function create(hris_employee_educations $employeeEducation)
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $educations = hris_educations::where('del_status', 0)->get();
            return view('pages.personalInformation.educations.create', compact('employeeEducation', 'educations'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function store(hris_employee_educations $employeeEducation, Request $request)
    {
        $employee_id = $_SESSION['sys_id'];
        if($this->validatedData()) {
            $employeeEducation->employee_id = $employee_id;
            $employeeEducation->education_id = request('education_id');
            $employeeEducation->institute = request('institute');
            $employeeEducation->start_date = request('start_date');
            $employeeEducation->completed = request('completed');
            $employeeEducation->del_status = 0;
            $employeeEducation->save();
            $id = $employeeEducation->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/personalInformation/educations/index')->with('success', 'Employee education successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_educations $employeeEducation)
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $educations = hris_educations::where('del_status', 0)->get();
            return view('pages.personalInformation.educations.edit', compact('employeeEducation', 'educations'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function update(hris_employee_educations $employeeEducation, Request $request)
    {
        $id = $employeeEducation->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee_educations';
            $employeeEducation->education_id = request('education_id');
            $employeeEducation->institute = request('institute');
            $employeeEducation->start_date = request('start_date');
            $employeeEducation->completed = request('completed');
            // GET CHANGES
            $changes = $employeeEducation->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employeeEducation->update();
            // GET CHANGES
            $changed = $employeeEducation->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employeeEducation->wasChanged() ) {
                return redirect('/hris/pages/personalInformation/educations/index')->with('success', 'Employee education successfully updated!');
            } else {
                return redirect('/hris/pages/personalInformation/educations/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_educations $employeeEducation)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            return back()->with(['You do not have access in this page.']);
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('password'), $employee->password) ) {
                $employeeEducation->del_status = 1;
                $employeeEducation->update();
                $id = $employeeEducation->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/personalInformation/educations/index')->with('success', 'Employee education successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'education_id' => 'required',
            'institute' => 'required',
            'start_date' => 'nullable',
            'completed' => 'nullable'
        ]);
    }

}
