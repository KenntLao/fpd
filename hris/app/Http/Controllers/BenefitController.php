<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_benefits;
use App\users;

class BenefitController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Recruitment Setup - Benefit';
    }
    public function index()
    {   
        $benefits = hris_benefits::orderBy('id')->paginate(10);
        return view('pages.recruitment.recruitmentSetup.benefits.index', compact('benefits'));
    }

    public function create(hris_benefits $benefit)
    {
        return view('pages.recruitment.recruitmentSetup.benefits.create', compact('benefit'));
    }

    public function store(hris_benefits $benefit, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $benefit = hris_benefits::create($this->validatedData());
            $id = $benefit->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success', 'Benefit successfully added!');
        } else {
            return back()->withErrors($this->validatedData);
        }

    }

    public function show($id)
    {
        //
    }

    public function edit(hris_benefits $benefit)
    {
        return view('pages.recruitment.recruitmentSetup.benefits.edit', compact('benefit'));
    }

    public function update(hris_benefits $benefit, Request $request)
    {
        $id = $benefit->id;
        if ($this->validatedData()) {
            $model = $benefit;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module);
            $benefit->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success', 'Benefit successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }


    public function destroy(hris_benefits $benefit)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $benefit->delete();
            $id = $benefit->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success','Benefit successfully deleted!');
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