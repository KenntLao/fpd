<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_employee;

class PersonalInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( $_SESSION['sys_account_mode'] == 'employee' ) {
            $id = $_SESSION['sys_id'];
            $employee = hris_employee::find($id);
            return view('pages.personalInformation.profile.index', compact('employee'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(hris_employee $employee)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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
