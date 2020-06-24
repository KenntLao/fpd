<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_itenerary_requests;
use App\hris_employee;
use App\users;

class IteneraryRequestController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Employee Management - Itenerary Request';
    }
    public function index()
    {
        $iteneraryRequests = hris_itenerary_requests::paginate(10);
        return view('pages.employees.iteneraryRequests.index', compact('iteneraryRequests'));
    }

    public function create(hris_itenerary_requests $iteneraryRequest)
    {
        $employees = hris_employee::all();
        return view('pages.employees.iteneraryRequests.create', compact('iteneraryRequest', 'employees'));
    }

    public function store(hris_itenerary_requests $iteneraryRequest, Request $request)
    {
        $action = 'add';
        $id = $_SESSION['sys_id'];
        
    }

    public function show(hris_itenerary_requests $iteneraryRequest)
    {
        //
    }

    public function edit(hris_itenerary_requests $iteneraryRequest)
    {
        $employees = hris_employee::all();
        return view('pages.employees.iteneraryRequests.create', compact('iteneraryRequest', 'employees'));
    }

    public function update(hris_itenerary_requests $iteneraryRequest, Request $request)
    {
        //
    }

    public function destroy(hris_itenerary_requests $iteneraryRequest)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $iteneraryRequest->delete();
                $id = $iteneraryRequest->id;
                $this->function->systemLog($this->module,$action,$id);
                return redirect('/hris/pages/employees/iteneraryRequests/index')->with('success','Itenerary request successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $iteneraryRequest->delete();
                $id = $iteneraryRequest->id;
                $this->function->systemLog($this->module,$action,$id);
                return redirect('/hris/pages/employees/iteneraryRequests/index')->with('success', 'Itenerary request successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'transportation' => 'required',
            'purpose' => 'required',
            'travel_from' => 'required',
            'travel_to' => 'required',
            'travel_date' => 'required',
            'return_date' => 'required',
            'notes' => 'nullable',
            'currency' => 'required',
            'total_funding_proposed' => 'required',
            'attachment_1' => 'nullable',
            'attachment_2' => 'nullable',
            'attachment_3' => 'nullable',
            'status' => 'nullable',
        ]);
    }
}
