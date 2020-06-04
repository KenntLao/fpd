<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\users;
use App\hris_leave_rules;

class LeaveRuleController extends Controller
{
    public function index()
    {
        $leaveRules = hris_leave_rules::paginate(10);
        return view('pages.admin.leave.leaveRules.index', compact('leaveRules'));
    }

    public function create(hris_leave_rules $leaveRule)
    {
        return view('pages.admin.leave.leaveRules.create', compact('leaveRule'));
    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function edit(hris_leave_rules $leaveRule)
    {
        return view('pages.admin.leave.leaveRules.edit', compact('leaveRule'));
    }

    public function update(hris_leave_rules $leaveRule, Request $request)
    {

    }

    public function destroy(hris_leave_rules $leaveRule)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveRule->delete();
            return redirect('/hris/pages/admin/leave/leaveRules/index')->with('success','Leave rule successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
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
