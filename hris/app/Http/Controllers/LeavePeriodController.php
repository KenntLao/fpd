<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_periods;
use App\users;

class LeavePeriodController extends Controller
{
    public function index()
    {
        $leavePeriods = hris_leave_periods::paginate(10);
        return view('pages.admin.leave.leavePeriods.index', compact('leavePeriods'));
    }

    public function create(hris_leave_periods $leavePeriod)
    {
        return view('pages.admin.leave.leavePeriods.create', compact('leavePeriod'));
    }

    public function store(hris_leave_periods $leavePeriod, Request $request)
    {
        if($this->validatedData()) {
            $leavePeriod::create($this->validatedData());
            return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_periods $leavePeriod)
    {
        return view('pages.admin.leave.leavePeriods.edit', compact('leavePeriod'));
    }

    public function update(hris_leave_periods $leavePeriod, Request $request)
    {
        if($this->validatedData()) {
            $leavePeriod->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_periods $leavePeriod)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leavePeriod->delete();
            return redirect('/hris/pages/admin/leave/leavePeriods/index')->with('success', 'Leave period successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'start' => 'required',
            'end' => 'required'
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
