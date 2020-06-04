<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employee_training_sessions;
use App\hris_training_sessions;
use App\users;

class EmployeeTrainingSessionController extends Controller
{
    public function index()
    {
        $employeeTrainingSessions = hris_employee_training_sessions::paginate(10);
        $id = hris_employee_training_sessions::all()->get('id');
        $training = hris_training_sessions::find($id);
        return view('pages.admin.training.employeeTrainingSessions.index', compact('employeeTrainingSessions', 'training'));
    }

    public function create(hris_employee_training_sessions $employeeTrainingSession)
    {
        $trainingSessions = hris_training_sessions::all();
        return view('pages.admin.training.employeeTrainingSessions.create', compact('employeeTrainingSession', 'trainingSessions'));
    }

    public function store(Request $request)
    {
        $employeeTrainingSession = new hris_employee_training_sessions();
        if($this->validatedData()) {
            $employeeTrainingSession->employee = request('employee');
            $employeeTrainingSession->training_session = request('training_session');
            $employeeTrainingSession->status = request('status');
            $employeeTrainingSession->save();
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee Training Session successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_training_sessions $employeeTrainingSession)
    {
        $trainingSessions = hris_training_sessions::all();
        return view('pages.admin.training.employeeTrainingSessions.edit', compact('employeeTrainingSession', 'trainingSessions'));
    }

    public function update(hris_employee_training_sessions $employeeTrainingSession, Request $request)
    {
        if($this->validatedData()) {
            $employeeTrainingSession->employee = request('employee');
            $employeeTrainingSession->training_session = request('training_session');
            $employeeTrainingSession->status = request('status');
            $employeeTrainingSession->update();
            return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee Training Session successfully updated!');

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
                return redirect('/hris/pages/admin/training/employeeTrainingSessions/index')->with('success', 'Employee Training Session successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'employee' => 'required',
            'training_session' => 'required',
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
