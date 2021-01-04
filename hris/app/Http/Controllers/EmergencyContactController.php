<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_emergency_contacts;
use App\hris_employee;

class EmergencyContactController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Personal Information - Emergency Contact';
    }
    public function index()
    {
        if( $_SESSION['sys_account_mode'] == 'employee' ) {
            $id = $_SESSION['sys_id'];
            $emergencies = hris_emergency_contacts::where('employee_id',$id)->get();
            return view('pages.personalInformation.emergencyContacts.index', compact('emergencies'));
        } else {
            return back();
        }
    }

    public function create(hris_emergency_contacts $emergency)
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            return view('pages.personalInformation.emergencyContacts.create', compact('emergency'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function store(hris_emergency_contacts $emergency, Request $request)
    {
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
            $this->function->addSystemLog($this->module,$id);
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
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            return view('pages.personalInformation.emergencyContacts.edit', compact('emergency'));
        } else {
            return back()->with(['You do not have access in this page.']);
        }
    }

    public function update(hris_emergency_contacts $emergency, Request $request)
    {
        $id = $emergency->id;
        if ($this->validatedData()) {
            $string = 'App\hris_emergency_contacts';
            $emergency->name = request('name');
            $emergency->relationship = request('relationship');
            $emergency->home_phone = request('home_phone');
            $emergency->work_phone = request('work_phone');
            $emergency->mobile_phone = request('mobile_phone');
            // GET CHANGES
            $changes = $emergency->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $emergency->update();
            // GET CHANGES
            $changed = $emergency->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $emergency->wasChanged() ) {
                return redirect('/hris/pages/personalInformation/emergencyContacts/index')->with('success', 'Emergency contact successfully updated!');
            } else {
                return redirect('/hris/pages/personalInformation/emergencyContacts/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_emergency_contacts $emergency)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            return back()->with(['You do not have access in this page.']);
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('password'), $employee->password) ) {
                $emergency->delete();
                $id = $emergency->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/personalInformation/emergencyContacts/index')->with('success', 'Emergency contact successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
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
