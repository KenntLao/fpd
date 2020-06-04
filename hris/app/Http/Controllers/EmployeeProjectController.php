<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employee_projects;
use App\hris_projects;
use App\users;
use App\hris_employee;

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
        $employees = hris_employee::all();
        return view('pages.admin.properties.employeeProjects.create', compact('employeeProject','projects', 'employees'));
    }


    public function store(Request $request)
    {
        $employeeProject = new hris_employee_projects();
        if($this->validatedData()) {
            $employeeProject->employee_id = request('employee_id');
            $employeeProject->project_id = request('project_id');
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
        $employees = hris_employee::all();
        return view('pages.admin.properties.employeeProjects.edit', compact('employeeProject', 'projects', 'employees'));
    }

    public function update(hris_employee_projects $employeeProject, Request $request)
    {
        if($this->validatedData()) {
            $employeeProject->employee_id = request('employee_id');
            $employeeProject->project_id = request('project_id');
            $employeeProject->details = request('details');
            $employeeProject->update();
            return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_projects $employeeProject)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employeeProject->delete();
            return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully deleted');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'project_id' => 'required'
        ]);
    }
    // decrypt string
    function decryptStr($str) {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c,0,$ivlen);
        $hmac = substr($c,$ivlen,$sha2len=32);
        $ciphertext_raw = substr($c,$ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw,$cipher,$key,$options=OPENSSL_RAW_DATA,$iv);
        $calcmac = hash_hmac('sha256',$ciphertext_raw,$key,$as_binary=true);
        if (hash_equals($hmac,$calcmac)) { return $original_plaintext; }
    }

}
