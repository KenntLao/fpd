<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_overtime_requests;
use App\hris_overtime_categories;
use App\hris_projects;
use App\users;
use App\hris_employee;

class OvertimeRequestController extends Controller
{
    public function index()
    {
        $overtimeRequests = hris_overtime_requests::paginate(10);
        return view('pages.admin.overtime.overtimeRequests.index', compact('overtimeRequests'));
    }

    public function create(hris_overtime_requests $overtimeRequest)
    {
        $overtimeCategories = hris_overtime_categories::all();
        $projects = hris_projects::all();
        $employees = hris_employee::all();
        return view('pages.admin.overtime.overtimeRequests.create', compact('overtimeRequest', 'overtimeCategories', 'projects','employees'));
    }

    public function store(Request $request)
    {
        $overtimeRequest = new hris_overtime_requests();
        if($this->validatedData()) {
            $overtimeRequest->employee_id = request('employee_id');
            $overtimeRequest->category_id = request('category_id');
            $overtimeRequest->start_time = request('start_time');
            $overtimeRequest->end_time = request('end_time');
            $overtimeRequest->project_id = request('project_id');
            $overtimeRequest->notes = request('notes');
            $overtimeRequest->status = 'Pending';
            $overtimeRequest->save();
            return redirect('/hris/pages/admin/overtime/overtimeRequests/index')->with('success', 'Overtime Request successfully added');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_overtime_requests $overtimeRequest)
    {
        $overtimeCategories = hris_overtime_categories::all();
        $projects = hris_projects::all();
        $employees = hris_employee::all();
        return view('pages.admin.overtime.overtimeRequests.edit', compact('overtimeRequest', 'overtimeCategories', 'projects', 'employees'));
    }

    public function update(hris_overtime_requests $overtimeRequest, Request $request)
    {
        if($this->validatedData()) {
            $overtimeRequest->employee_id = request('employee_id');
            $overtimeRequest->category_id = request('category_id');
            $overtimeRequest->start_time = request('start_time');
            $overtimeRequest->end_time = request('end_time');
            $overtimeRequest->project_id = request('project_id');
            $overtimeRequest->notes = request('notes');
            $overtimeRequest->status = 'Pending';
            $overtimeRequest->update();
            return redirect('/hris/pages/admin/overtime/overtimeRequests/index')->with('success', 'Overtime Request successfully updated');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function updateStatus(hris_overtime_requests $overtimeRequest, Request $request)
    {
        $overtimeRequest->status = request('status');
        $overtimeRequest->update();
        return redirect('/hris/pages/admin/overtime/overtimeRequests/index')->with('success', 'Overtime Request status successfully updated!');
    }

    public function destroy(hris_overtime_requests $overtimeRequest)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $overtimeRequest->delete();
            return redirect('/hris/pages/admin/overtime/overtimeRequests/index')->with('success', 'Overtime Request successfully deleted');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'category_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
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
