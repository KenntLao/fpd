<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_job_titles;
use App\users;

class JobTitleController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Job Details Setup - Job Title';
    }
    public function index()
    {   
        $jobTitles = hris_job_titles::paginate(10);
        return view('pages.admin.jobDetails.jobTitles.index', compact('jobTitles'));
    }

    public function create(hris_job_titles $jobTitle)
    {
        return view('pages.admin.jobDetails.jobTitles.create', compact('jobTitle'));
    }


    public function store(hris_job_titles $jobTitle, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $jobTitle = hris_job_titles::create($this->validatedData());
            $id = $jobTitle->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {

    }

    public function edit(hris_job_titles $jobTitle)
    {
        return view('pages.admin.jobDetails.jobTitles.edit', compact('jobTitle'));
    }

    public function update(hris_job_titles $jobTitle, Request $request)
    {
        $id = $jobTitle->id;
        if($this->validatedData()) {
            $model = $jobTitle;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $jobTitle->update($this->validatedData());
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_job_titles $jobTitle)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $jobTitle->delete();
            $id = $jobTitle->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job title successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() {

        return request()->validate([
            'code' => 'required',
            'name' => 'required',
            'description' => 'required',
            'specification' => 'required'
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
