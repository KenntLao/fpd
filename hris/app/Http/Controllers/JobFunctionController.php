<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_job_functions;
use App\users;

class JobFunctionController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Recruitment Setup - Job  Function';
    }
    public function index()
    {   
        $jobFunctions = hris_job_functions::paginate(10);
        return view('pages.recruitment.recruitmentSetup.jobFunctions.index', compact('jobFunctions'));
    }

    public function create(hris_job_functions $jobFunction)
    {
        return view('pages.recruitment.recruitmentSetup.jobFunctions.create', compact('jobFunction'));
    }

    public function store(hris_job_functions $jobFunction, Request $request)
    {
        $action = 'add';
        $systemLog = new SystemLogController;
        if ($this->validatedData()) {
            $jobFunction = hris_job_functions::create($this->validatedData());
            $id = $jobFunction->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success', 'Job function successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {
  
    }

    public function edit(hris_job_functions $jobFunction)
    {
        return view('pages.recruitment.recruitmentSetup.jobFunctions.edit', compact('jobFunction'));
    }

    public function update(hris_job_functions $jobFunction, Request $request)
    {
        $id = $jobFunction->id;
        if ($this->validatedData()) {
            $model = $jobFunction;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $jobFunction->update($this->validatedData());
            return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success', 'Job function successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }  
    }

    public function destroy(hris_job_functions $jobFunction)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $jobFunction->delete();
            $id = $jobFunction->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/recruitmentSetup/jobFunctions/index')->with('success','Job function successfully deleted!');
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