<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employee_training_sessions;
use App\hris_training_sessions;
use App\users;
use App\hris_employee;

class EmployeeTrainingSessionController extends Controller
{
    public function index()
    {
        $employeeTrainingSessions = hris_employee_training_sessions::paginate(10);
        return view('pages.admin.training.employeeTrainingSessions.index', compact('employeeTrainingSessions'));
    }

    public function create(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employees = hris_employee::all();
        $trainingSessions = hris_training_sessions::all();
        return view('pages.admin.training.employeeTrainingSessions.create', compact('employeeTrainingSession', 'trainingSessions', 'employees'));
    }

    public function store(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        if($this->validatedData()) {
            $employeeTrainingSession::create($this->validatedData());
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_training_sessions $employeeTrainingSession)
    {
        $employees = hris_employee::all();
        $trainingSessions = hris_training_sessions::all();
        return view('pages.admin.training.employeeTrainingSessions.edit', compact('employeeTrainingSession', 'trainingSessions', 'employees'));
    }

    public function update(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        if($this->validatedData()) {
            $employeeTrainingSession->update($this->validatedData());
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully updated!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_training_sessions $employeeTrainingSession)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employeeTrainingSession->delete();
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee training session successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'employee_id' => 'required',
            'training_session_id' => 'required',
            'status' => 'required'
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
