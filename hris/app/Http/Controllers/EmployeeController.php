<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employee;
class EmployeeController extends Controller
{
//
    public function index(){
        $employees = hris_employee::paginate(10);
        return view('pages.employees.employee.index', compact('employees'));
    }

    public function create(hris_employee $employees)
    {
        return view('pages.employees.employee.create', compact('employees'));
    }

    public function store(Request $request, hris_employee $employees) {
        if($this->validatedData()){
            // check data if valid
            if ($request->hasFile('employee_photo')) {
                $imageName = time() . '.' . $request->employee_photo->extension();
            }
            $employees->employee_photo = $imageName;
            $employees->employee_number = request('employee_number');
            $employees->firstname = request('firstname');
            $employees->middlename = request('middlename');
            $employees->lastname = request('lastname');
            $employees->job_position = request('job_position');
            $employees->work_no = request('work_no');
            $employees->work_phone = request('work_phone');
            $employees->work_email = request('work_email');
            $employees->department = request('department');
            $employees->supervisor = request('supervisor');
            $employees->work_address = request('work_address');
            $employees->sss = request('sss');
            $employees->pagibig = request('pagibig');
            $employees->phic = request('phic');
            $employees->joined_date = request('joined_date');
            $employees->employment_status = request('employment_status');
            $employees->termination_date = request('termination_date');
            $employees->home_address = request('home_address');
            $employees->private_email = request('private_email');
            $employees->bank_acc = request('bank_acc');
            $employees->home_distance = request('home_distance');
            $employees->marital_status = request('marital_status');
            $employees->emergency_contact = request('emergency_contact');
            $employees->emergency_no = request('emergency_no');
            $employees->cert_level = request('cert_level');
            $employees->field_study = request('field_study');
            $employees->school = request('school');
            $employees->passport_no = request('passport_no');
            $employees->gender = request('gender');
            $employees->nationality = request('nationality');
            $employees->birthday = request('birthday');
            $employees->place_birth = request('place_birth');
            $employees->dependant = request('dependant');
            $employees->visa_no = request('visa_no');
            $employees->work_permit = request('work_permit');
            $employees->visa_expire = request('visa_expire');
            $employees->save();
            $request->employee_photo->move(public_path('assets/images/employees/employee_photos/'), $imageName);
            return redirect('/hris/pages/employees/employee/index')->with('success', 'Employee successfully added!');   
        }else { // if data fails
                return back()->withErrors($this->validatedData());
            }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'employee_number' => 'required',
            'firstname' => 'required',
            'middlename' => 'required',
            'lastname' => 'required',
            'job_position' => 'required',
            'work_no' => 'required',
            'work_phone' => 'nullable',
            'work_email' => 'email',
            'department' => 'required',
            'supervisor' => 'required',
            'work_address' => 'required',
            'sss' => 'nullable',
            'pagibig' => 'nullable',
            'phic' => 'nullable',
            'joined_date' => 'required|date',
            'employment_status' => 'required',
            'termination_date' => 'nullable|date',
            'home_address' => 'required',
            'private_email' => 'required|email',
            'bank_acc' => 'required',
            'home_distance' => 'nullable',
            'marital_status' => 'required',
            'emergency_contact' => 'required',
            'emergency_no' => 'required',
            'cert_level' => 'required',
            'field_study' => 'required',
            'school' => 'required',
            'passport_no' => 'nullable',
            'gender' => 'required',
            'nationality' => 'required',
            'birthday' => 'required|date',
            'place_birth' => 'required',
            'dependant' => 'nullable',
            'visa_no' => 'nullable',
            'work_permit' => 'nullable',
            'visa_expire' => 'nullable',
        ]);
    }
}
