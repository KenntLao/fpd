<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_employee_certifications;
use App\hris_employee;
use App\hris_certifications;

class EmployeeCertificationController extends Controller
{
    public function index()
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $employeeCertifications = hris_employee_certifications::paginate(10);
            return view('pages.personalInformation.certifications.index', compact('employeeCertifications'));
        }
    }

    public function create(hris_employee_certifications $employeeCertification)
    {
        $certifications = hris_certifications::all();
        return view('pages.personalInformation.certifications.create', compact('employeeCertification', 'certifications'));
    }

    public function store(hris_employee_certifications $employeeCertification, Request $request)
    {
        $employee_id = $_SESSION['sys_id'];
        if ($this->validatedData()) {
            $employeeCertification->employee_id = $employee_id;
            $employeeCertification->certification_id = request('certification_id');
            $employeeCertification->institute = request('institute');
            $employeeCertification->granted_on = request('granted_on');
            $employeeCertification->valid_thru = request('valid_thru');
            $employeeCertification->save();
            return redirect('/hris/pages/personalInformation/certifications/index')->with('success', 'Employee certification successfully added!');
        } else {
            return back()->withErrors($this->validateData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_certifications $employeeCertification)
    {
        $certifications = hris_certifications::all();
        return view('pages.personalInformation.certifications.edit', compact('employeeCertification', 'certifications'));
    }

    public function update(hris_employee_certifications $employeeCertification, Request $request)
    {
        if ($this->validatedData()) {
            $employeeCertification->update($this->validatedData());
            return redirect('/hris/pages/personalInformation/certifications/index')->with('success', 'Employee certification successfully added!');
        } else {
            return back()->withErrors($this->validateData());
        }
    }

    public function destroy(hris_employee_certifications $employeeCertification)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if ( Hash::check(request('password'), $employee->password) ) {
            $employeeCertification->delete();
            return redirect('/hris/pages/personalInformation/certifications/index')->with('success', 'Employee education successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'certification_id' => 'required',
            'institute' => 'required',
            'granted_on' => 'nullable',
            'valid_thru' => 'nullable',
        ]);
    }

}
