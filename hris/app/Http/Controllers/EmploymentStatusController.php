<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employment_statuses;
use App\users;

class EmploymentStatusController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Job Details Setup - Employment Status';
    }
    public function index()
    {
        $employmentStatuses = hris_employment_statuses::paginate(10);
        return view('pages.admin.jobDetails.employmentStatuses.index', compact('employmentStatuses'));
    }

    public function create(hris_employment_statuses $employmentStatus)
    {
        return view('pages.admin.jobDetails.employmentStatuses.create', compact('employmentStatus'));
    }

    public function store(hris_employment_statuses $employmentStatus, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $employmentStatus = hris_employment_statuses::create($this->validatedData());
            $id = $employmentStatus->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment status successfully added!');
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
        $id = $employmentStatus->id;
        if($this->validatedData()) {
            $model = $employmentStatus;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $employmentStatus->update($this->validatedData());
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment status successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employment_statuses $employmentStatus)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employmentStatus->delete();
            $id = $employmentStatus->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/employmentStatuses/index')->with('success', 'Employment status successfully deleted!');
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
