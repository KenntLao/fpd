<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_educations;
use App\users;

class EducationController extends Controller
{
    public function index()
    {
        $educations = hris_educations::paginate(10);
        return view('pages.admin.qualifications.educations.index', compact('educations'));
    }

    public function create(hris_educations $education)
    {
        return view('pages.admin.qualifications.educations.create', compact('education'));
    }

    public function store(hris_educations $education, Request $request)
    {
        if($this->validatedData()) {
            $education::create($this->validatedData());
            return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_educations $education)
    {
        return view('pages.admin.qualifications.educations.edit', compact('education'));
    }

    public function update(hris_educations $education, Request $request)
    {
        if($this->validatedData()) {
            $education->update($this->validatedData());
            return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_educations $education)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $education->delete();
            return redirect('/hris/pages/admin/qualifications/educations/index')->with('success', 'Education successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
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
