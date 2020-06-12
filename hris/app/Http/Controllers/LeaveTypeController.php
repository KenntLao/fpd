<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leave_groups;
use App\hris_leave_types;
use App\users;

class LeaveTypeController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Leave Settings - Leave Type';
    }
    public function index()
    {
        $leaveTypes = hris_leave_types::paginate(10);
        return view('pages.admin.leave.leaveTypes.index', compact('leaveTypes'));
    }

    public function create(hris_leave_types $leaveType)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveTypes.create', compact('leaveType', 'leaveGroups'));
    }

    public function store(hris_leave_types $leaveType, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $leaveType = hris_leave_types::create($this->validatedData());
            $id = $leaveType->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_leave_types $leaveType)
    {
        $leaveGroups = hris_leave_groups::all();
        return view('pages.admin.leave.leaveTypes.edit', compact('leaveType', 'leaveGroups'));
    }

    public function update(hris_leave_types $leaveType, Request $request)
    {
        $id = $leaveType->id;
        if($this->validatedData()) {
            $model = $leaveType;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $leaveType->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_types $leaveType)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveType->delete();
            $id = $leaveType->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveTypes/index')->with('success', 'Leave Type successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'leaves_per_period' => 'required',
            'supervisor_leave_assign' => 'required',
            'employee_can_apply' => 'required',
            'apply_beyond_current' => 'required',
            'leave_accrue' => 'required',
            'carried_forward' => 'required',
            'carried_forward_percentage' => 'required',
            'max_carried_forward_amount' => 'required',
            'carried_forward_leave_availability' => 'required',
            'proportionate_on_joined_date' => 'required',
            'employee_leave_period' => 'required',
            'send_notification_emails' => 'required',
            'leave_group_id' => 'nullable',
            'leave_color' => 'required'
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
