<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employee_projects;
use App\hris_projects;
use App\users;
use App\hris_employee;

class EmployeeProjectController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Properties Setup - Employee Project';
    }

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


    public function store(hris_employee_projects $employeeProject, Request $request)
    {
        $action = 'add'
        if($this->validatedData()) {
            $employeeProject = hris_employee_projects::create($this->validatedData());
            $id = $employeeProject->id;
            $this->systemLog->systemLog($this->module,$action,$id);
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
        $projects = hris_projects::all();
        $employees = hris_employee::all();
        return view('pages.admin.properties.employeeProjects.edit', compact('employeeProject', 'projects', 'employees'));
    }

    public function update(hris_employee_projects $employeeProject, Request $request)
    {
        $id = $employeeProject->id;
        if($this->validatedData()) {
            $model = $employeeProject;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $employeeProject->update($this->validatedData());
            return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_projects $employeeProject)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employeeProject->delete();
            $id = $employeeProject->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/properties/employeeProjects/index')->with('success', 'Employee Project successfully deleted');
        } else {
            return back()->withErrors(['Password does not match.']);
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
