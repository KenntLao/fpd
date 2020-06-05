<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employment_types;
use App\users;

class EmploymentTypeController extends Controller
{
    public function index()
    {
        $employmentTypes = hris_employment_types::paginate(10);
        return view('pages.recruitment.recruitmentSetup.employmentTypes.index', compact('employmentTypes'));
    }

    public function create(hris_employment_types $employmentType)
    {
        return view('pages.recruitment.recruitmentSetup.employmentTypes.create', compact('employmentType'));
    }

    public function store(hris_employment_types $employmentType, Request $request)
    {
        if ($this->validatedData()) {
            $employmentType::create($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success', 'Employment type successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $employmentType = hris_employment_types::find($id);
        return view('pages.recruitment.recruitmentSetup.employmentTypes.edit', compact('employmentType'));
    }

    public function update(hris_employment_types $employmentType, Request $request)
    {
        if ($this->validatedData()) {
            $employmentType->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success', 'Employment type successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        } 
    }

    public function destroy(hris_employment_types $employmentType)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employmentType->delete();
            return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success','Employment type successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }


    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required|max:100'
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
