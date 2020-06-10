<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\users;
use App\hris_paid_time_offs;
use App\hris_leave_types;
use App\hris_leave_periods;
use App\hris_employee;

class PaidTimeOffController extends Controller
{

    public function index()
    {
        $paidTimeOffs = hris_paid_time_offs::paginate(10);
        return view('pages.admin.leave.paidTimeOffs.index', compact('paidTimeOffs'));
    }

    public function create(hris_paid_time_offs $paidTimeOff)
    {
        $leaveTypes = hris_leave_types::all();
        $leavePeriods = hris_leave_periods::all();
        $employees = hris_employee::all();
        return view('pages.admin.leave.paidTimeOffs.create', compact('paidTimeOff', 'leaveTypes', 'leavePeriods', 'employees'));
    }

    public function store(hris_paid_time_offs $paidTimeOff, Request $request)
    {
        if ($this->validatedData()) {
            $paidTimeOff::create($this->validatedData());
            return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success', 'Paid time off successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_paid_time_offs $paidTimeOff)
    {
        $leaveTypes = hris_leave_types::all();
        $leavePeriods = hris_leave_periods::all();
        $employees = hris_employee::all();
        return view('pages.admin.leave.paidTimeOffs.edit', compact('paidTimeOff', 'leaveTypes', 'leavePeriods', 'employees'));
    }

    public function update(hris_paid_time_offs $paidTimeOff, Request $request)
    {
        if ($this->validatedData()) {
            $paidTimeOff->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success', 'Paid time off successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_paid_time_offs $paidTimeOff)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $paidTimeOff->delete();
            return redirect('/hris/pages/admin/leave/paidTimeOffs/index')->with('success','Paid time off successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'leave_type_id' => 'required',
            'employee_id' => 'required',
            'leave_period_id' => 'required',
            'amount' => 'required',
            'note' => 'nullable'
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
