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
        if($this->validatedData()) {
            $certification = hris_certifications::create($this->validatedData());
            $id = $certification->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_certifications';
            $certification->name = request('name');
            $certification->description = request('description');
            // GET CHANGES
            $changes = $certification->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $certification->update();
            // GET CHANGES
            $changed = $certification->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $certification->wasChanged() ) {
                return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully updated!');
            } else {
                return redirect('/hris/pages/admin/qualifications/certifications/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_certifications $certification)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $certification->delete();
            $id = $certification->id;
            $this->function->deleteSystemLog($this->module,$id);
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
