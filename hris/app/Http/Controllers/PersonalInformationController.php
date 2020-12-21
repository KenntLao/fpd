<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_employee;
use App\users;

class PersonalInformationController extends Controller
{

    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Personal Information - Basic Information';
    }
    public function index()
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $employee = hris_employee::where('id',$id)->first();
            return view('pages.personalInformation.profile.index', compact('employee'));
        } else {
            return back();
        }
    }

    public function edit(hris_employee $id)
    {
        return view('pages.personalInformation.profile.edit', compact('id'));
    }

    public function update(hris_employee $employee, Request $request)
    {
        $id = $employee->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee';
            if( $request->hasFile('employee_photo') ) {
                $path =  public_path('assets/images/employees/employee_photos/');
                if ($employee->employee_photo != '' && $employee->employee_photo != NULL) {
                    $old_file = $path . $employee->employee_photo;
                    unlink($old_file);
                    $imageName = time() . 'EP.' . $request->employee_photo->extension();
                    $employee->employee_photo = $imageName;
                    $request->employee_photo->move($path, $imageName);
                }
            }
            $employee->birthday = request('birthday');
            $employee->gender = request('gender');
            $employee->nationality = request('nationality');
            $employee->marital_status = request('marital_status');
            $employee->work_address = request('work_address');
            $employee->home_address = request('home_address');
            $employee->work_phone = request('work_phone');
            $employee->private_email = request('private_email');
            // GET CHANGES
            $changes = $employee->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employee->update();
            // GET CHANGES
            $changed = $employee->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employee->wasChanged() ) {
                return redirect('/hris/pages/personalInformation/profile/index')->with('success', 'Profile information successfully updated!');
            } else {
                return redirect('/hris/pages/personalInformation/profile/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function changePass()
    {
        $id = $_SESSION['sys_id'];
        $password = request('old_pass');
        $employee = hris_employee::find($id);
        if($password == password_verify($password,$employee->password)) {
            $new_pass = password_hash(request('new_pass'), PASSWORD_DEFAULT);
            $employee->password = $new_pass;
            $employee->update();
            return redirect('/hris/pages/personalInformation/profile/index')->with('success', 'Password successfully updated');
        } else {
            return back()->withErrors(['Password does not match!']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_photo' => 'nullable',
            'work_address' => 'nullable',
            'home_address' => 'nullable',
            'work_phone' => 'nullable',
            'private_email' => 'nullable',
        ]);
    }
     
}
