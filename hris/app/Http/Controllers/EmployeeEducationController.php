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
            $employeeEducations = hris_employee_educations::paginate(10);
            return view('pages.personalInformation.educations.index', compact('employeeEducations'));
        }
    }

    public function create(hris_employee_educations $employeeEducation)
    {
        $educations = hris_educations::all();
        return view('pages.personalInformation.educations.create', compact('employeeEducation', 'educations'));
    }

    public function store(hris_employee_educations $employeeEducation, Request $request)
    {
        $action = 'add';
        $employee_id = $_SESSION['sys_id'];
        if($this->validatedData()) {
            $employeeEducation->employee_id = $employee_id;
            $employeeEducation->education_id = request('education_id');
            $employeeEducation->institute = request('institute');
            $employeeEducation->start_date = request('start_date');
            $employeeEducation->completed = request('completed');
            $employeeEducation->save();
            $id = $employeeEducation->id;
            $this->function->systemLog($this->module,$action,$id);
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
        $educations = hris_educations::all();
        return view('pages.personalInformation.educations.edit', compact('employeeEducation', 'educations'));
    }

    public function update(hris_employee_educations $employeeEducation, Request $request)
    {
        $id = $employeeEducation->id;
        if($this->validatedData()) {
            $model = $employeeEducation;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $employeeEducation->update($this->validatedData());
            return redirect('/hris/pages/personalInformation/educations/index')->with('success', 'Employee education successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_educations $employeeEducation)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if ( Hash::check(request('password'), $employee->password) ) {
            $employeeEducation->delete();
            $id = $employeeEducation->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/personalInformation/educations/index')->with('success', 'Employee education successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
