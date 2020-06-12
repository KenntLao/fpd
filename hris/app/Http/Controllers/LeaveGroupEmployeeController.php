<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_group_employees;
use App\hris_leave_groups;
use App\users;
use App\hris_employee;

class LeaveGroupEmployeeController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Leave Settings - Leave Group Employee';
    }
    public function index()
    {
        $leaveGroupEmployees = hris_leave_group_employees::paginate(10);
        return view('pages.admin.leave.leaveGroupEmployees.index', compact('leaveGroupEmployees'));
    }

    public function create(hris_leave_group_employees $leaveGroupEmployee)
    {
        $leaveGroups = hris_leave_groups::all();
        $employees = hris_employee::all();
        return view('pages.admin.leave.leaveGroupEmployees.create', compact('leaveGroupEmployee', 'leaveGroups', 'employees'));
    }

    public function store(hris_leave_group_employees $leaveGroupEmployee, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $leaveGroupEmployee = hris_leave_group_employees::create($this->validatedData());
            $id = $jobTitle->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_group_employees $leaveGroupEmployee)
    {
        $leaveGroups = hris_leave_groups::all();
        $employees = hris_employee::all();
        return view('pages.admin.leave.leaveGroupEmployees.edit', compact('leaveGroupEmployee', 'leaveGroups', 'employees'));
    }

    public function update(hris_leave_group_employees $leaveGroupEmployee, Request $request)
    {
        $id = $jobTitle->id;
        if ($this->validatedData()) {
            $model = $jobTitle;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $leaveGroupEmployee->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_group_employees $leaveGroupEmployee)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveGroupEmployee->delete();
            $id = $jobTitle->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave group employee successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'leave_group_id' => 'required'
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
