<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\users;
use App\hris_employee;
use App\hris_projects;
use App\hris_npa;
use App\roles;

class NpaController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Recruitment Setup - NPA';
    }
    public function index()
    {
        $npas = hris_npa::latest()->paginate(15);
        return view('pages.recruitment.npa.index', compact('npas'));
    }

    public function create(hris_npa $npa)
    {
        $projects = hris_projects::all();
        $employees = hris_employee::all();
        return view('pages.recruitment.npa.create', compact('npa','employees','projects'));
    }

    public function store(Request $request, hris_npa $npa)
    {
        if ( $this->validatedData() ) {
            if ( $request->project_id == $request->designation_from_id ) {
                return back()->withErrors(['"Designation from" invalid']);
            } else {
                $npa->request_mode = $_SESSION['sys_account_mode'];
                $npa->request_date = $request->request_date;
                $npa->attention = $request->attention;
                $npa->ref_no = $request->ref_no;
                $npa->sender_id = $_SESSION['sys_id'];
                $npa->project_id = $request->project_id;
                $npa->employee_id = $request->employee_id;
                $npa->reason = $request->reason;
                $npa->designation_from_id = $request->designation_from_id;
                $npa->designation_to_id = $request->project_id;
                $npa->bs_from = $request->bs_from;
                $npa->bs_to = $request->bs_to;
                $npa->a_from = $request->a_from;
                $npa->a_to = $request->a_to;
                $npa->cola_from = $request->cola_from;
                $npa->cola_to = $request->cola_to;
                $npa->effectivity_date = $request->effectivity_date;
                $npa->save();
                $id = $npa->id;
                $this->function->addSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA successfully added!');
            }
        } else {
            return back()->withErrors($this->validatedData()); 
        }
    }

    public function show(hris_npa $npa)
    {
        if ( $npa->request_mode == 'user' ) {
            $supervisor_id = 0;
            $user = users::find($_SESSION['sys_id']);
            $role_ids = explode(',',$user->role_ids);
        } else {
            $employee = hris_employee::find($npa->sender_id);
            $supervisor_id = $employee->supervisor;
            $role_ids = explode(',',$employee->role_id);
        }
        $sess_roles = explode(',', $_SESSION['sys_role_ids']);
        $hr_recruitment = roles::where('role_name', 'hr recruitment')->first();
        $hr_id = $hr_recruitment->id;
        return view('pages.recruitment.npa.show', compact('npa','supervisor_id','hr_id', 'role_ids', 'sess_roles'));
    }

    public function edit(hris_npa $npa)
    {
        $projects = hris_projects::all();
        $employees = hris_employee::all();
        return view('pages.recruitment.npa.edit', compact('npa','employees','projects'));
    }

    public function reject(hris_npa $npa)
    {
        return view('pages.recruitment.npa.reject', compact('npa'));
    }

    public function update(Request $request, hris_npa $npa)
    {
        if ( $this->validatedData() ) {
            if ( $request->project_id == $request->designation_from_id ) {
                return back()->withErrors(['"Designation from" invalid']);
            } else {
                $npa->request_mode = $_SESSION['sys_account_mode'];
                $npa->request_date = $request->request_date;
                $npa->attention = $request->attention;
                $npa->ref_no = $request->ref_no;
                $npa->sender_id = $_SESSION['sys_id'];
                $npa->project_id = $request->project_id;
                $npa->reason = $request->reason;
                $npa->designation_from_id = $request->designation_from_id;
                $npa->designation_to_id = $request->project_id;
                $npa->bs_from = $request->bs_from;
                $npa->bs_to = $request->bs_to;
                $npa->a_from = $request->a_from;
                $npa->a_to = $request->a_to;
                $npa->cola_from = $request->cola_from;
                $npa->cola_to = $request->cola_to;
                $npa->effectivity_date = $request->effectivity_date;
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA successfully added!');
            }
        } else {
            return back()->withErrors($this->validatedData()); 
        }
    }

    public function rejectSubmit(Request $request, hris_npa $npa)
    {
        if ( $this->rejectData() ) {
            $npa->remarks = $request->remarks;
            $npa->status = 3;
            $npa->update();
            return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA rejected!');
        } else {
            return back()->withErrors($this->rejectData()); 
        }
    }

    public function approve(hris_npa $npa)
    {
        if ( $npa->request_mode == 'user' ) {
            $supervisor_id = 0;
            $user = users::find($_SESSION['sys_id']);
            $role_ids = explode(',',$user->role_ids);
        } else {
            $employee = hris_employee::find($npa->sender_id);
            $supervisor_id = $employee->supervisor;
            $role_ids = explode(',',$employee->role_id);
        }
        $hr_recruitment = roles::where('role_name', 'hr recruitment')->first();
        $hr_id = $hr_recruitment->id;
        $sess_roles = explode(',', $_SESSION['sys_role_ids']);
        if ( $_SESSION['sys_role_ids'] == ',1,' OR $_SESSION['sys_id'] == $supervisor_id ) {
            if ( $npa->status == 0 ) {
                $npa->status = 1;
                $npa->update();
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA processing!');
            } else {
                if ( $_SESSION['sys_role_ids'] == ',1,' ) {
                    $npa->status = 2;
                    $npa->approve_mode = $_SESSION['sys_account_mode'];
                    $npa->approve_id = $_SESSION['sys_id'];
                    $npa->update();
                    return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA processing!');
                } else {
                    return back();
                }
            }
        } elseif ( in_array($hr_id, $sess_roles) ) {
            if ( $npa->status == 0 ) {
                return back();
            } else {
                $npa->status = 2;
                $npa->approve_mode = $_SESSION['sys_account_mode'];
                $npa->approve_id = $_SESSION['sys_id'];
                $npa->update();
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA approved!');
            }
        } else {
            return back();
        }
    }

    public function destroy(hris_npa $npa)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $npa->delete();
                $id = $npa->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }

        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('password'), $employee->password) ) {
                $npa->delete();
                $id = $npa->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'request_date' => 'required',
            'attention' => 'required',
            'ref_no' => 'required',
            'sender_id' => 'nullable',
            'employee_id' => 'required',
            'project_id' => 'required',
            'reason' => 'required',
            'designation_from_id' => 'required',
            'designation_to_id' => 'nullable',
            'bs_from' => 'required',
            'bs_to' => 'required',
            'a_from' => 'required',
            'a_to' => 'required',
            'cola_from' => 'required',
            'cola_to' => 'required',
            'effectivity_date' => 'required|after:request_date',
            'remarks' => 'nullable',
        ]);
    }

    protected function rejectData()
    {
        return request()->validate([
            'remarks' => 'required',
        ]);
    }
}