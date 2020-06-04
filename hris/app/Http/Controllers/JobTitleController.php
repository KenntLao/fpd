<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_job_titles;
use App\users;

class JobTitleController extends Controller
{
    public function index()
    {   
        $jobTitles = hris_job_titles::paginate(10);
        return view('pages.admin.jobDetails.jobTitles.index', compact('jobTitles'));
    }

    public function create(hris_job_titles $jobTitle)
    {
        return view('pages.admin.jobDetails.jobTitles.create', compact('jobTitle'));
    }


    public function store(Request $request)
    {

        $jobTitle = new hris_job_titles();
        if ($this->validatedData()) {
            $jobTitle->code = request('code');
            $jobTitle->name = request('name');
            $jobTitle->description = request('description');
            $jobTitle->specification = request('specification');
            $jobTitle->save();
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job Title successfully added!');
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
        if($this->validatedData()) {
            $jobTitle->code = request('code');
            $jobTitle->name = request('name');
            $jobTitle->description = request('description');
            $jobTitle->specification = request('specification');
            $jobTitle->update();
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job Title successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_job_titles $jobTitle)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $jobTitle->delete();
            return redirect('/hris/pages/admin/jobDetails/jobTitles/index')->with('success', 'Job Title successfully deleted!');
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
