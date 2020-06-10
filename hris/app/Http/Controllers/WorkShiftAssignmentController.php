<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_workshift_assignment;
use App\hris_work_shift_management;
use App\hris_employee;
use App\users;

class WorkShiftAssignmentController extends Controller
{
    //
    public function index(hris_workshift_assignment $workshift_assignment)
    {
        $workshift_assignment = hris_workshift_assignment::paginate(10);

        $employee = hris_employee::join('hris_workshift_assignments', 'hris_workshift_assignments.employee_id', '=', 'hris_employees.id')->get();
        $workshift = hris_work_shift_management::join('hris_workshift_assignments', 'hris_workshift_assignments.workshift_id', '=', 'hris_work_shift_managements.id')->get();
        return view('pages.time.workshiftAssignment.index', compact('workshift_assignment', 'employee', 'workshift'));
    }
    public function create(hris_workshift_assignment $workshift_assignment, hris_employee $employees, hris_work_shift_management $work_shift)
    {
        $employees = hris_employee::all();
        $work_shift = hris_work_shift_management::all();
        return view('pages.time.workshiftAssignment.create', compact('workshift_assignment', 'employees', 'work_shift'));
    }
    public function store()
    {
        if ($this->validatedData()) {
            hris_workshift_assignment::create($this->validatedData());
            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function edit(hris_workshift_assignment $workshift_assignment, hris_employee $employees, hris_work_shift_management $work_shift){
        $employees = hris_employee::all();
        $employee = hris_employee::with('getEmployeeWorkShiftAssignmentRelation')->first();
        $work_shift = hris_work_shift_management::all();
        $workshift_rel = hris_work_shift_management::with('getWorkShiftAssignmentRelation')->first();
        return view('pages.time.workshiftAssignment.edit', compact('workshift_assignment','employee','workshift_rel','employees', 'work_shift'));
    }
    public function update(Request $request, hris_workshift_assignment $workshift_assignment){
        if ($this->validatedData()) {
            $workshift_assignment->update($this->validatedData());
            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully assigned!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function destroy(hris_workshift_assignment $workshift_assignment)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ($upass == request('upass')) {
            $workshift_assignment->delete();
            return redirect('/hris/pages/time/workshiftAssignment/index')->with('success', 'Work Shift successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    // decrypt string
    function decryptStr($str)
    {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $ciphertext_raw = substr($c, $ivlen + $sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary = true);
        if (hash_equals($hmac, $calcmac)) {
            return $original_plaintext;
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'workshift_id' => 'required',
            'date_from' => 'required',
            'date_to' => 'required',
        ]);
    }
}
