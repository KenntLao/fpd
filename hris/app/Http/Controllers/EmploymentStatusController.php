<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employment_statuses;
use App\users;

class EmploymentStatusController extends Controller
{
    public function index()
    {
        $employmentStatuses = hris_employment_statuses::paginate(10);
        return view('pages.admin.jobDetails.employmentStatuses.index', compact('employmentStatuses'));
    }

    public function create(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.create', compact('employmentStatus'));
    }

    public function store(Request $request)
    {
        $employmentStatus = new hris_employment_statuses();
        if($this->validatedData()) {
            $employmentStatus->name = request('name');
            $employmentStatus->description = request('description');
            $employmentStatus->save();
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment Status successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.edit', compact('employmentStatus'));
    }

    public function update(hris_employment_statuses $employmentStatus ,Request $request)
    {
        if($this->validatedData()) {
            $employmentStatus->name = request('name');
            $employmentStatus->description = request('description');
            $employmentStatus->update();
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment Status successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employment_statuses $employmentStatus)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employmentStatus->delete();
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment Status successfully deleted!');
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
