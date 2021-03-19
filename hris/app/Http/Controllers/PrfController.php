<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_prf;
use App\hris_employee;
use App\roles;
use App\hris_employment_statuses;
use App\hris_candidates;
use App\hris_company_structures;
use App\hris_job_titles;
class PrfController extends Controller
{
    public function __construct()
    {
        $this->function = new FunctionController;
        $this->module = 'Recruitment - PRF';
    }

    public function index()
    {
        if($_SESSION['sys_account_mode'] == "employee"){
            $current_user_id = $_SESSION['sys_id'];
            // GET HR RECRUITMENT ROLE ID
            $hr_recruitment_id = roles::where('role_name', 'hr recruitment')->pluck('id')->first();
            // GET DIRECTOR ROLE ID
            $director_id = roles::where('role_name', 'director')->pluck('id')->first();
            // GET SUPERVISOR ROLE ID
            $supervisor_id = roles::where('role_name', 'supervisor')->pluck('id')->first();
            // GET CURRENT USER ROLE ID
            $employee = hris_employee::where('id', $current_user_id)->first();
            $employee_ids = explode(',', $employee->role_id);
            // GET MANAGER_OM ROLE ID
            $manager_om_id = roles::where('role_name', 'manager_om')->pluck('id')->first();


            if (in_array($director_id, $employee_ids) && in_array($supervisor_id, $employee_ids)) {

                $prfs = hris_prf::where('supervisor_id', $current_user_id)->get();

            } elseif (in_array($hr_recruitment_id, $employee_ids)) {

                $prfs = hris_prf::where('initial_status','!=',0)->get();

            } elseif (in_array($manager_om_id, $employee_ids)) {

                $prfs = hris_prf::where('employee_id', $current_user_id)->get();

            } else {
                return back()->with('error', 'You are not authorized to access this page.');
            }

            return view('pages.recruitment.prf.index', compact('prfs', 'employee_ids', 'manager_om_id', 'hr_recruitment_id'));
        } else {
            return back()->with('error', 'You are not authorized to access this page.');
        }
        
    }

    public function create(hris_prf $prf)
    {
       $data = hris_prf::all();
        if(!$prf){
            $ctr_number = $this->getSequence(1);
        } else {

            $control_number = $prf::orderByDesc('id')->pluck('control_no')->first() + 1;
            $ctr_number = $this->getSequence($control_number);

        }
        return view('pages.recruitment.prf.create', compact('prf','ctr_number'));
    }

    public function getSequence($num) {
        return sprintf("%'.06d\n", $num);
    }

    public function store(Request $request, hris_prf $prf){
        if($this->validatedData()){
            $user_id = $_SESSION['sys_id'];

            $user_position = hris_employee::where('id',$user_id)->pluck('job_title_id')->first();
            $user_department = hris_employee::where('id',$user_id)->pluck('department_id')->first();
            $user_supervisor = hris_employee::where('id',$user_id)->pluck('supervisor')->first();

            $prf->control_no = $request->control_no;
            $prf->date_filed = date('Y-m-d');
            $prf->education = $request->education;
            $prf->work_exp = $request->work_exp;
            $prf->skills = $request->skills;
            $prf->duty_desc = $request->duty_desc;
            $prf->reason = $request->reason;
            $prf->basic_rate = $request->basic_rate;
            $prf->allowance = $request->allowance;
            $prf->project_based = $request->project_based;
            $prf->cmo_based = $request->cmo_based;
            $prf->employee_id = $user_id;
            $prf->employee_position_id = $user_position;
            $prf->department_id = $user_department;
            $prf->employee_department_id = $user_department;
            $prf->initial_status = 0; //0 pending 1 initially approved 2 final approval 3 rejected
            $prf->del_status = 0;
            $prf->supervisor_id = $user_supervisor;


            if(isset($request->cmo_remarks)){
                $prf->cmo_remarks = $request->cmo_remarks;
            }

            $path = public_path('assets/files/recruitment/prf_client_approval/');
            $path2 = public_path('assets/files/recruitment/prf_labor_approval/');

            if(isset($request->client_approval_file)){
                if($request->hasFile('client_approval_file')){
                    $imageName = time() . 'EP.' . $request->client_approval_file->extension();
                    $prf->client_approval_file = $imageName;
                    $request->client_approval_file->move($path, $imageName);
                }
            }
            if(isset($request->labor_approval_file)){
                if($request->hasFile('labor_approval_file')){
                    $imageName2 = time() . 'EP.' . $request->labor_approval_file->extension();
                    $prf->labor_approval_file = $imageName2;
                    $request->labor_approval_file->move($path2, $imageName2);
                }
            }
            $prf->save();
            return redirect('/hris/pages/recruitment/prf/index')->with('success', 'PRF request successfully added!');
        } else { // if data fails
            return back()->withErrors($this->validatedData());
        }
    }

    public function edit(hris_prf $prf)
    {
        return view('pages.recruitment.prf.edit', compact('prf'));
    }
    public function show(hris_prf $prf)
    {
        $current_user_id = $_SESSION['sys_id'];
        // GET HR RECRUITMENT ROLE ID
        $hr_recruitment_id = roles::where('role_name', 'hr recruitment')->pluck('id')->first();
        // GET CURRENT USER ROLE ID
        $employee_id = hris_employee::where('id', $current_user_id)->first();
        $employee_ids = explode(',', $employee_id->role_id);

        $employee = hris_employee::where('id',$prf->employee_id)->first();
        return view('pages.recruitment.prf.show', compact('prf','employee','hr_recruitment_id','employee_ids'));
    }

    public function update(Request $request, hris_prf $prf)
    {
        if ($this->validatedData()) {
            $user_id = $_SESSION['sys_id'];

            $user_position = hris_employee::where('id', $user_id)->pluck('job_title_id')->first();
            $user_department = hris_employee::where('id', $user_id)->pluck('department_id')->first();
            $user_supervisor = hris_employee::where('id', $user_id)->pluck('supervisor')->first();

            $prf->control_no = $request->control_no;
            $prf->date_filed = date('Y-m-d');
            $prf->education = $request->education;
            $prf->work_exp = $request->work_exp;
            $prf->skills = $request->skills;
            $prf->duty_desc = $request->duty_desc;
            $prf->reason = $request->reason;
            $prf->basic_rate = $request->basic_rate;
            $prf->allowance = $request->allowance;
            $prf->project_based = $request->project_based;
            $prf->cmo_based = $request->cmo_based;
            $prf->employee_id = $user_id;
            $prf->employee_position_id = $user_position;
            $prf->department_id = $user_department;
            $prf->employee_department_id = $user_department;
            $prf->initial_status = 0; //0 pending 1 initially approved 2 final approval 3 rejected
            $prf->supervisor_id = $user_supervisor;


            if (isset($request->cmo_remarks)) {
                $prf->cmo_remarks = $request->cmo_remarks;
            }

            $path = public_path('assets/files/recruitment/prf_client_approval/');
            $path2 = public_path('assets/files/recruitment/prf_labor_approval/');

            if (isset($request->client_approval_file)) {
                
                if ($prf->client_approval_file != '' && $prf->client_approval_file != NULL) {
                    $old_file = $path . $prf->client_approval_file;
                    unlink($old_file);
                }

                if ($request->hasFile('client_approval_file')) {
                    $imageName = time() . 'EP.' . $request->client_approval_file->extension();
                    $prf->client_approval_file = $imageName;
                    $request->client_approval_file->move($path, $imageName);
                }
            }
            
            if (isset($request->labor_approval_file)) {

                if ($prf->labor_approval_file != '' && $prf->labor_approval_file != NULL) {
                    $old_file = $path2 . $prf->labor_approval_file;
                    unlink($old_file);
                }
                
                if ($request->hasFile('labor_approval_file')) {
                    $imageName2 = time() . 'EP.' . $request->labor_approval_file->extension();
                    $prf->labor_approval_file = $imageName2;
                    $request->labor_approval_file->move($path2, $imageName2);
                }
            }
            $prf->update();
            return redirect('/hris/pages/recruitment/prf/index')->with('success', 'PRF request successfully updated!');
        } else { // if data fails
            return back()->withErrors($this->validatedData());
        }
    }

    public function approve(Request $request, hris_prf $prf){
        $current_user_id = $_SESSION['sys_id'];
        // GET HR RECRUITMENT ROLE ID
        $hr_recruitment_id = roles::where('role_name', 'hr recruitment')->pluck('id')->first();
        // GET CURRENT USER ROLE ID
        $employee_id = hris_employee::where('id', $current_user_id)->first();
        $employee_ids = explode(',', $employee_id->role_id);

        if(in_array($hr_recruitment_id,$employee_ids)){
            $employment_status = hris_employment_statuses::all();
            $employee = hris_employee::where('id', $prf->employee_id)->first();
            $supervisor = hris_employee::where('id', $prf->supervisor_id)->first();
            $candidates = hris_candidates::all();
            $designation = hris_company_structures::where('id',$prf->department_id)->first();
            $hr_detail = hris_employee::where('id',$current_user_id)->first();
            $job_positions = hris_job_titles::all();
            return view('pages.recruitment.prf.hr-approve-form', compact('prf', 'employee','supervisor', 'employment_status','candidates', 'designation', 'hr_detail', 'job_positions'));

        } else {
            $prf->initial_status = 1;
            $prf->update();
            return redirect('/hris/pages/recruitment/prf/index')->with('success', 'PRF request successfully approved!');
        }
    }

    public function HrApprove(Request $request, hris_prf $prf){
        $hr_id = $_SESSION['sys_id'];
        if($this->hrApproveData()){
            $prf->action = $request->action;
            $prf->employment_status_id = $request->employment_status_id;
            $prf->duration_from = $request->duration_from;
            $prf->duration_to = $request->duration_to;
            $prf->initial_status = 2;
            $candidate_ids = implode(',', $request->candidates);
            $prf->candidate_id = ','.$candidate_ids.',';
            $prf->candidate_salary = $request->candidate_salary;
            $prf->candidate_hire_date = $request->candidate_hire_date;
            $prf->candidate_position = $request->candidate_position;
            $prf->hr_id = $hr_id;
            $prf->pod_date = date('Y-m-d');
            $prf->pod_receiver_id = $prf->supervisor_id;
            $prf->pod_type = $request->pod_type;
            $prf->update();
            return redirect('/hris/pages/recruitment/prf/index')->with('success', 'PRF request successfully approved!');
        } else {
            return back()->withErrors(['Invalid Input.']);
        }
    }

    public function reject(hris_prf $prf){
        $employee = hris_employee::where('id', $prf->employee_id)->first();
        return view('pages.recruitment.prf.reject-form', compact('prf','employee'));
    }
    public function rejectSubmit(hris_prf $prf, Request $request){
        if($this->rejectData()){
            $prf->initial_status = 3;
            $prf->reject_remarks = $request->reject_remarks;
            $prf->update();
            return redirect('/hris/pages/recruitment/prf/index')->with('success', 'PRF request successfully rejected!');
        } else {
            return back()->withErrors(['Remarks is required']);
        }
    }
    public function showFinal(hris_prf $prf){
        $current_user_id = $_SESSION['sys_id'];
        // GET HR RECRUITMENT ROLE ID
        $hr_recruitment_id = roles::where('role_name', 'hr recruitment')->pluck('id')->first();
        // GET CURRENT USER ROLE ID
        $employee_id = hris_employee::where('id', $current_user_id)->first();
        $employee_ids = explode(',', $employee_id->role_id);

        $designation = hris_company_structures::where('id', $prf->department_id)->first();
        $supervisor = hris_employee::where('id', $prf->supervisor_id)->first();

        $hr_detail = hris_employee::where('id',$prf->hr_id)->first();

        $employee = hris_employee::where('id', $prf->employee_id)->first();
        return view('pages.recruitment.prf.final-approved-form', compact('prf', 'employee', 'hr_recruitment_id', 'employee_ids', 'supervisor', 'designation', 'hr_detail'));
    }
    protected function validatedData()
    {
        return request()->validate([
            'control_no' => 'required',
            'education' => 'nullable',
            'work_exp' => 'nullable',
            'skills' => 'nullable',
            'age' => 'nullable',
            'duty_desc' => 'nullable',
            'reason' => 'nullable',
            'basic_rate' => 'nullable',
            'allowance' => 'nullable',
            'cola' => 'nullable',
            'project_based' => 'nullable',
            'cmo_based' => 'nullable',
            'cmo_remarks' => 'nullable',
            'client_approval_file' => 'nullable|mimes:doc,docx,pdf',
            'labor_approval_file' => 'nullable|mimes:doc,docx,pdf',
        ]);
    }

    protected function rejectData()
    {
        return request()->validate([
            'reject_remarks' => 'required',
        ]);
    }

    protected function hrApproveData()
    {
        return request()->validate([
            'action' => 'nullable',
            'employment_status_id' => 'nullable',
            'duration_from' => 'nullable',
            'duration_to' => 'nullable',
        ]);
    }

}
