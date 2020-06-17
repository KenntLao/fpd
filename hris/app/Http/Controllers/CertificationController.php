<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_certifications;
use App\users;

class CertificationController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Qualifications Setup - Certification';
    }
    public function index()
    {
        $certifications = hris_certifications::paginate(10);
        return view('pages.admin.qualifications.certifications.index', compact('certifications'));
    }

    public function create(hris_certifications $certification)
    {
        return view('pages.admin.qualifications.certifications.create', compact('certification'));
    }

    public function store(hris_certifications $certification, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $certification = hris_certifications::create($this->validatedData());
            $id = $certification->id;
            $this->function->systemLog($this->module,$action,$id);
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
        $id = $certification->id;
        if($this->validatedData()) {
            $model = $certification;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $certification->update($this->validatedData());
            return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_certifications $certification)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $certification->delete();
            $id = $certification->id;
            $this->function->systemLog($this->module,$action,$id);
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
