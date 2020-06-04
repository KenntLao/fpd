<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_certifications;
use App\users;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = hris_certifications::paginate(10);
        return view('pages.admin.qualifications.certifications.index', compact('certifications'));
    }

    public function create(hris_certifications $certification)
    {
        return view('pages.admin.qualifications.certifications.create', compact('certification'));
    }

    public function store(Request $request)
    {
        $certification = new hris_certifications();
        if($this->validatedData()) {
            $certification->name = request('name');
            $certification->description = request('description');
            $certification->save();
            return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_certifications $certification)
    {
        return view('pages.admin.qualifications.certifications.edit', compact('certification'));
    }

    public function update(hris_certifications $certification, Request $request)
    {
        if($this->validatedData()) {
            $certification->name = request('name');
            $certification->description = request('description');
            $certification->update();
            return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_certifications $certification)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $certification->delete();
            return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully deleted!');
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
