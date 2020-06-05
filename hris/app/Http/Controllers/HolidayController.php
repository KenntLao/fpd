<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_holidays;
use App\hris_countries;
use App\users;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = hris_holidays::paginate(10);
        return view('pages.admin.leave.holidays.index', compact('holidays'));
    }

    public function create(hris_holidays $holiday)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.holidays.create', compact('holiday', 'countries'));
    }

    public function store(hris_holidays $holiday, Request $request)
    {
        if($this->validatedData()) {
            $holiday::create($this->validatedData());
            return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_holidays $holiday)
    {
        $countries = hris_countries::all();
        return view('pages.admin.leave.holidays.edit', compact('holiday', 'countries'));
    }

    public function update(hris_holidays $holiday, Request $request)
    {
        if($this->validatedData()) {
            $holiday->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_holidays $holiday)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $holiday->delete();
            return redirect('/hris/pages/admin/leave/holidays/index')->with('success', 'Holiday successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'holiday_date' => 'required',
            'status' => 'required',
            'country' => 'nullable'
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
