<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_employee;

class PersonalInformationController extends Controller
{

    public function index()
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $id = $_SESSION['sys_id'];
            $employee = hris_employee::find($id);
            return view('pages.personalInformation.profile.index', compact('employee'));
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
     
}
