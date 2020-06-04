<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_work_weeks;
use App\hris_countries;
use App\users;

class WorkWeekController extends Controller
{
    public function index()
    {
        $workWeeks = hris_work_weeks::paginate(10);
        return view('pages.admin.leave.workWeeks.index', compact('workWeeks'));
    }

    public function create(hris_work_weeks $workWeek)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.workWeeks.create', compact('workWeek', 'countries'));
    }

    public function store(Request $request)
    {
        $workWeek = new hris_work_weeks();
        if($this->validatedData()) {
            $workWeek->day = request('day');
            $workWeek->status = request('status');
            $workWeek->country = request('country');
            $workWeek->save();
            return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_work_weeks $workWeek)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.workWeeks.edit', compact('workWeek', 'countries'));
    }

    public function update(hris_work_weeks $workWeek, Request $request)
    {
        if($this->validatedData()) {
            $workWeek->day = request('day');
            $workWeek->status = request('status');
            $workWeek->country = request('country');
            $workWeek->update();
            return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_work_weeks $workWeek)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $workWeek->delete();
            return redirect('/hris/pages/admin/leave/workWeeks/index')->with('success', 'Work Week successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'day' => 'required',
            'status' => 'required'
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
