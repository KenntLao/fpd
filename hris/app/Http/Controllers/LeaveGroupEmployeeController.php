<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_group_employees;
use App\hris_leave_groups;
use App\users;

class LeaveGroupEmployeeController extends Controller
{
    public function index()
    {
        $leaveGroupEmployees = hris_leave_group_employees::paginate(10);
        return view('pages.admin.leave.leaveGroupEmployees.index', compact('leaveGroupEmployees'));
    }

    public function create(hris_leave_group_employees $leaveGroupEmployee)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveGroupEmployees.create', compact('leaveGroupEmployee', 'leaveGroups'));
    }

    public function store(Request $request)
    {
        $leaveGroupEmployee = new hris_leave_group_employees();
        if ($this->validatedData()) {
            $leaveGroupEmployee->employee = request('employee');
            $leaveGroupEmployee->leave_group = request('leave_group');
            $leaveGroupEmployee->save();
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave Group Employee successfully added!');
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
        return view('pages.admin.leave.leaveGroupEmployees.edit', compact('leaveGroupEmployee', 'leaveGroups'));
    }

    public function update(hris_leave_group_employees $leaveGroupEmployee, Request $request)
    {
        if ($this->validatedData()) {
            $leaveGroupEmployee->employee = request('employee');
            $leaveGroupEmployee->leave_group = request('leave_group');
            $leaveGroupEmployee->update();
            return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave Group Employee successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_group_employees $leaveGroupEmployee)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveGroupEmployee->delete();
                return redirect('/hris/pages/admin/leave/leaveGroupEmployees/index')->with('success', 'Leave Group Employee successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee' => 'required',
            'leave_group' => 'required'
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
