<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_leave_groups;
use App\users;

class LeaveGroupController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Leave Settings - Leave Group';
    }
    public function index()
    {
        $leaveGroups = hris_leave_groups::paginate(10);
        return view('pages.admin.leave.leaveGroups.index', compact('leaveGroups'));
    }

    public function create(hris_leave_groups $leaveGroup)
    {
        return view('pages.admin.leave.leaveGroups.create', compact('leaveGroup'));
    }

    public function store(hris_leave_groups $leaveGroup, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $leaveGroup = hris_leave_groups::create($this->validatedData());
            $id = $leaveGroup->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {

    }

    public function edit(hris_leave_groups $leaveGroup)
    {
        return view('pages.admin.leave.leaveGroups.edit', compact('leaveGroup'));
    }

    public function update(hris_leave_groups $leaveGroup, Request $request)
    {
        $id = $leaveGroup->id;
        if ($this->validatedData()) {
            $model = $leaveGroup;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $leaveGroup->update($this->validatedData());
            return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully updated!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_leave_groups $leaveGroup)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $leaveGroup->delete();
            $id = $leaveGroup->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/leave/leaveGroups/index')->with('success', 'Leave group successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'details' => 'nullable'
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
