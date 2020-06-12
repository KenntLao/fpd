<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_education_levels;
use App\users;

class EducationLevelController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Recruitment Setup - Education Level';
    }
    public function index()
    {   
        $educationLevels = hris_education_levels::paginate(10);
        return view('pages.recruitment.recruitmentSetup.educationLevels.index', compact('educationLevels'));
    }

    public function create(hris_education_levels $educationLevel)
    {
        return view('pages.recruitment.recruitmentSetup.educationLevels.create', compact('educationLevel'));
    }

    public function store(hris_education_levels $educationLevel, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $educationLevel = hris_education_levels::create($this->validatedData());
            $id = $educationLevel->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(hris_education_levels $educationLevel)
    {
        return view('pages.recruitment.recruitmentSetup.educationLevels.edit', compact('educationLevel'));
    }

    public function update(hris_education_levels $educationLevel, Request $request)
    {
        $id = $educationLevel->id;
        if ($this->validatedData()) {
            $model = $educationLevel;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $educationLevel->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        } 
    }

    public function destroy(hris_education_levels $educationLevel)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $educationLevel->delete();
            $id = $educationLevel->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success','Education level successfully deleted!');
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
