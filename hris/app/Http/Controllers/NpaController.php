<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\users;
use App\hris_employee;
use App\hris_projects;
use App\hris_npa;
use App\roles;
use App\hris_job_titles;
use App\hris_employee_projects;
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
        $manager_om = roles::where('role_name', 'manager_om')->first();
        $m_id = $manager_om->id;
        $director = roles::where('role_name', 'director')->first();
        $d_id = $director->id;
        $hr_recruitment = roles::where('role_name', 'hr recruitment')->first();
        $hr_id = $hr_recruitment->id;
        $op_assistant_id = roles::where('role_name','operation assistant')->pluck('id')->first();
        $sess_roles = explode(',', $_SESSION['sys_role_ids']);
        $npas = hris_npa::latest()->where('del_status', 0)->paginate(15);
        $job_titles = hris_job_titles::all();
        
        if ( in_array($m_id, $sess_roles) OR in_array($d_id, $sess_roles) OR in_array($hr_id, $sess_roles) OR in_array($op_assistant_id, $sess_roles) ) {
            return view('pages.recruitment.npa.index', compact('npas','m_id','sess_roles','job_titles','op_assistant_id'));
        } else {
            return back()->withErrors(['You are not authorized to access this page.']);
        }
    }

    public function create(hris_npa $npa)
    {
        $projects = hris_projects::all()->where('del_status', 0);
        $employees = hris_employee::all()->where('del_status', 0);
        $manager_om = roles::where('role_name', 'manager_om')->first();
        $m_id = $manager_om->id;
        $op_assistant_id = roles::where('role_name','operation assistant')->pluck('id')->first();
        $sess_roles = explode(',', $_SESSION['sys_role_ids']);
        $job_titles = hris_job_titles::all();
        if ( in_array($m_id, $sess_roles) OR in_array($op_assistant_id, $sess_roles) ) {
            return view('pages.recruitment.npa.create', compact('npa','employees','projects','job_titles'));
        } else {
            return back()->withErrors(['You are not authorized to access this page.']);
        }
    }

    public function store(Request $request, hris_npa $npa)
    {
        if ( $this->validatedData() ) {
            if ( $request->project_id == $request->designation_from_id ) {
                return back()->withErrors(['"Designation from" invalid']);
            } else {
                $manager_om = roles::where('role_name', 'manager_om')->first();
                $m_id = $manager_om->id;
                $op_assistant_id = roles::where('role_name','operation assistant')->pluck('id')->first();
                $sess_roles = explode(',', $_SESSION['sys_role_ids']);

                if ( in_array($m_id, $sess_roles) OR in_array($op_assistant_id, $sess_roles) ) {
                    $npa->request_mode = $_SESSION['sys_account_mode'];
                    $npa->request_date = $request->request_date;
                    $npa->attention = $request->attention;
                    $npa->ref_no = $request->ref_no;
                    $npa->sender_id = $_SESSION['sys_id'];
                    $npa->project_from_id = $request->project_from_id;
                    $npa->project_to_id = $request->project_to_id;
                    $npa->employee_id = $request->employee_id;
                    $npa->reason = $request->reason;
                    $npa->designation_from_id = $request->designation_from_id;
                    $npa->designation_to_id = $request->designation_to_id;
                    $npa->bs_from = $request->bs_from;
                    $npa->bs_to = $request->bs_to;
                    $npa->a_from = $request->a_from;
                    $npa->a_to = $request->a_to;
                    $npa->cola_from = $request->cola_from;
                    $npa->cola_to = $request->cola_to;
                    $npa->effectivity_date = $request->effectivity_date;
                    $npa->del_status = 0;
                    $npa->save();
                    $id = $npa->id;
                    $this->function->addSystemLog($this->module,$id);
                    return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA successfully added!');
                } else {
                    return back()->withErrors(['You are not authorized to access this page.']);
                }
            }
        } else {
            return back()->withErrors($this->validatedData()); 
        }
    }

    public function show(hris_npa $npa)
    {
        $employee = hris_employee::find($npa->sender_id);
        $supervisor_id = $employee->supervisor;
        $role_ids = explode(',',$employee->role_id);

        $sess_roles = explode(',', $_SESSION['sys_role_ids']);
        $manager_om = roles::where('role_name', 'manager_om')->first();
        $m_id = $manager_om->id;
        $hr_recruitment = roles::where('role_name', 'hr recruitment')->first();
        $hr_id = $hr_recruitment->id;
        $director = roles::where('role_name', 'director')->first();
        $d_id = $director->id;
        $op_assistant_id = roles::where('role_name','operation assistant')->pluck('id')->first();
        $job_titles = hris_job_titles::all();
        if ( in_array($m_id, $sess_roles) OR in_array($d_id, $sess_roles) OR in_array($hr_id, $sess_roles) OR in_array($op_assistant_id, $sess_roles) ) {
            return view('pages.recruitment.npa.show', compact('npa','supervisor_id','hr_id', 'role_ids', 'sess_roles','d_id','job_titles'));
        } else {
            return back()->withErrors(['You are not authorized to access this page.']);
        }

    }

    public function edit(hris_npa $npa)
    {
        $projects = hris_projects::all()->where('del_status', 0);
        $employees = hris_employee::all()->where('del_status', 0);
        $manager_om = roles::where('role_name', 'manager_om')->first();
        $m_id = $manager_om->id;
        $op_assistant_id = roles::where('role_name','operation assistant')->pluck('id')->first();
        $sess_roles = explode(',', $_SESSION['sys_role_ids']);
        $job_titles = hris_job_titles::all();
        if ( in_array($m_id, $sess_roles) OR in_array($op_assistant_id, $sess_roles) ) {
            return view('pages.recruitment.npa.edit', compact('npa','employees','projects','job_titles'));
        } else {
            return back()->withErrors(['You are not authorized to access this page.']);
        }
    }

    public function reject(hris_npa $npa)
    {
        $employee = hris_employee::find($npa->sender_id);
        $supervisor_id = $employee->supervisor;

        $hr_recruitment = roles::where('role_name', 'hr recruitment')->first();
        $hr_id = $hr_recruitment->id;
        $director = roles::where('role_name', 'director')->first();
        $d_id = $director->id;
        $sess_roles = explode(',', $_SESSION['sys_role_ids']);

        if ( $_SESSION['sys_id'] == $supervisor_id AND in_array($d_id, $sess_roles) OR in_array($hr_id, $sess_roles) ) {
            return view('pages.recruitment.npa.reject', compact('npa'));
        } else {
            return back()->withErrors(['You are not authorized to access this page.']);
        }
    }

    public function update(Request $request, hris_npa $npa)
    {
        if ( $this->validatedData() ) {
            if ( $request->project_id == $request->designation_from_id ) {
                return back()->withErrors(['"Designation from" invalid']);
            } else {
                $manager_om = roles::where('role_name', 'manager_om')->first();
                $m_id = $manager_om->id;
                $op_assistant_id = roles::where('role_name','operation assistant')->pluck('id')->first();
                $sess_roles = explode(',', $_SESSION['sys_role_ids']);

                if ( in_array($m_id, $sess_roles) OR in_array($op_assistant_id, $sess_roles) ) {
                    $npa->request_mode = $_SESSION['sys_account_mode'];
                    $npa->request_date = $request->request_date;
                    $npa->attention = $request->attention;
                    $npa->ref_no = $request->ref_no;
                    $npa->sender_id = $_SESSION['sys_id'];
                    $npa->project_from_id = $request->project_from_id;
                    $npa->project_to_id = $request->project_to_id;
                    $npa->reason = $request->reason;
                    $npa->designation_from_id = $request->designation_from_id;
                    $npa->designation_to_id = $request->designation_to_id;
                    $npa->bs_from = $request->bs_from;
                    $npa->bs_to = $request->bs_to;
                    $npa->a_from = $request->a_from;
                    $npa->a_to = $request->a_to;
                    $npa->cola_from = $request->cola_from;
                    $npa->cola_to = $request->cola_to;
                    $npa->effectivity_date = $request->effectivity_date;
                    return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA successfully added!');
                } else {
                    return back()->withErrors(['You are not authorized to access this page.']);
                }
            }
        } else {
            return back()->withErrors($this->validatedData()); 
        }
    }

    public function rejectSubmit(Request $request, hris_npa $npa)
    {
        if ( $this->rejectData() ) {

            $employee = hris_employee::find($npa->sender_id);
            $supervisor_id = $employee->supervisor;

            $director = roles::where('role_name', 'director')->first();
            $d_id = $director->id;
            $hr_recruitment = roles::where('role_name', 'hr recruitment')->first();
            $hr_id = $hr_recruitment->id;
            $sess_roles = explode(',', $_SESSION['sys_role_ids']);

            if ( in_array($hr_id, $sess_roles) OR $_SESSION['sys_id'] == $supervisor_id AND in_array($d_id, $sess_roles) ) {
                $npa->approve_mode = $_SESSION['sys_account_mode'];
                $npa->approve_id = $_SESSION['sys_id'];
                $npa->remarks = $request->remarks;
                $npa->status = 3;
                $npa->update();
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA rejected!');
            } else {
                return back()->withErrors(['You are not authorized to access this page.']);
            }
        } else {
            return back()->withErrors($this->rejectData()); 
        }
    }

    public function approve(hris_npa $npa)
    {
        $employee = hris_employee::find($npa->sender_id);
        $supervisor_id = $employee->supervisor;

        $director = roles::where('role_name', 'director')->first();
        $d_id = $director->id;
        $hr_recruitment = roles::where('role_name', 'hr recruitment')->first();
        $hr_id = $hr_recruitment->id;
        $sess_roles = explode(',', $_SESSION['sys_role_ids']);

        if ( $_SESSION['sys_id'] == $supervisor_id AND in_array($d_id, $sess_roles) ) {
            if ( $npa->status == 0 ) {
                $npa->status = 1;
                $npa->update();
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA processing!');
            } else {
                return back();
            }
        } elseif ( in_array($hr_id, $sess_roles) ) {
            if ( $npa->status == 1 ) {
                $npa->status = 2;
                $npa->approve_mode = $_SESSION['sys_account_mode'];
                $npa->approve_id = $_SESSION['sys_id'];
                $npa->update();
                return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA approved!');
            } else {
                return back();
            }
        } else {
            return back()->withErrors(['You are not authorized to access this page.']);
        }
    }

    public function destroy(hris_npa $npa)
    {
        $id = $_SESSION['sys_id'];
        $manager_om = roles::where('role_name', 'manager_om')->first();
        $m_id = $manager_om->id;
        $op_assistant_id = roles::where('role_name','operation assistant')->pluck('id')->first();
        $sess_roles = explode(',', $_SESSION['sys_role_ids']);

        if ( in_array($m_id, $sess_roles) OR in_array($op_assistant_id, $sess_roles) ) {
            if ( $_SESSION['sys_account_mode'] == 'user' ) {
                $upass = $this->function->decryptStr(users::find($id)->upass);
                if ( $upass == request('upass') ) {
                    $npa->del_status = 1;
                    $npa->update();
                    $id = $npa->id;
                    $this->function->deleteSystemLog($this->module,$id);
                    return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA successfully deleted!');
                } else {
                    return back()->withErrors(['Password does not match.']);
                }

            } else {
                $employee = hris_employee::find($id);
                if ( Hash::check(request('password'), $employee->password) ) {
                    $npa->del_status = 1;
                    $npa->update();
                    $id = $npa->id;
                    $this->function->deleteSystemLog($this->module,$id);
                    return redirect('/hris/pages/recruitment/npa/index')->with('success','NPA successfully deleted!');
                } else {
                    return back()->withErrors(['Password does not match.']);
                }
            }
        } else {
            return back()->withErrors(['You are not authorized to access this page.']);
        }
    }

    public function getJobTitle(Request $request){
        $employee_id = $request->get('employee_id');
        $employee_job_title_id = hris_employee::where('id',$employee_id)->pluck('job_title_id')->first();
        if($employee_job_title_id != 0) {
            $job_title = hris_job_titles::find($employee_job_title_id)->first();
            $output = '<option value="' . $job_title->id . '">' . $job_title->name . '</option>';
            
        } else {
            $output = '<option value="0">None</option>';
        }
        echo $output;
        
    }

    public function getProject(Request $request){
        $employee_id = $request->get('employee_id');
        $employee_project_id = hris_employee_projects::where('employee_id',$employee_id)->pluck('id')->first();
        $project = hris_projects::where('id',$employee_project_id)->first();
        
        if($project) {
            $output = '<option value="' . $project->id . '">' . $project->name . '</option>';
            
        } else {
            $output = '<option value="0">None</option>';
        }
        echo $output;
        
    }

    protected function validatedData()
    {
        return request()->validate([
            'request_date' => 'required',
            'attention' => 'required',
            'ref_no' => 'required',
            'sender_id' => 'nullable',
            'employee_id' => 'required',
            'project_from_id' => 'required',
            'project_to_id' => 'required',
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