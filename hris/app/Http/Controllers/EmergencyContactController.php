<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_emergency_contacts;
use App\hris_employee;

class EmergencyContactController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Personal Information - Emergency Contact';
    }
    public function index()
    {
        if( $_SESSION['sys_account_mode'] == 'employee' ) {
            $emergencies = hris_emergency_contacts::paginate(10);
            return view('pages.personalInformation.emergencyContacts.index', compact('emergencies'));
        }
    }

    public function create(hris_emergency_contacts $emergency)
    {
        return view('pages.personalInformation.emergencyContacts.create', compact('emergency'));
    }

    public function store(hris_emergency_contacts $emergency, Request $request)
    {
        $action = 'add';
        $employee_id = $_SESSION['sys_id'];
        if ($this->validatedData()) {
            $emergency->employee_id = $employee_id;
            $emergency->name = request('name');
            $emergency->relationship = request('relationship');
            $emergency->home_phone = request('home_phone');
            $emergency->work_phone = request('work_phone');
            $emergency->mobile_phone = request('mobile_phone');
            $emergency->save();
            $id = $emergency->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/personalInformation/emergencyContacts/index')->with('success', 'Emergency contact successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_emergency_contacts $emergency)
    {
        return view('pages.personalInformation.emergencyContacts.edit', compact('emergency'));
    }

    public function update(hris_emergency_contacts $emergency, Request $request)
    {
        $id = $emergency->id;
        if ($this->validatedData()) {
            $model = $emergency;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $emergency->update($this->validatedData());
            return redirect('/hris/pages/personalInformation/emergencyContacts/index')->with('success', 'Emergency contact successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_emergency_contacts $emergency)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if ( Hash::check(request('password'), $employee->password) ) {
            $emergency->delete();
            $id = $emergency->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/personalInformation/emergencyContacts/index')->with('success', 'Emergency contact successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'relationship' => 'nullable',
            'home_phone' => 'nullable',
            'work_phone' => 'nullable',
            'mobile_phone' => 'nullable',
        ]);
    }

}