<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_candidates;
use App\hris_job_positions;
use App\hris_countries;
use App\users;
use App\table_careers_application;
use App\roles;
use App\hris_employee;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CandidateImport;

class CandidateController extends Controller
{

    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Recruitment Setup - Candidate';
    }
    public function index()
    {
        if($_SESSION['sys_account_mode'] == "employee") {
            $current_user_id = $_SESSION['sys_id'];
            $hr_recruitment_id = roles::where('role_name', 'hr recruitment')->pluck('id')->first();

            // GET CURRENT USER ROLE ID
            $employee = hris_employee::where('id', $current_user_id)->first();
            $employee_ids = explode(',', $employee->role_id);


            $candidates = table_careers_application::all()->where('del_status', 0);
            return view('pages.recruitment.candidates.index', compact('candidates', 'hr_recruitment_id', 'employee_ids'));
        } else {
            return back();
        }
    }

    public function create(hris_candidates $candidate)
    {   
        $jobPositions = hris_job_positions::where('del_status', 0)->get();
        $countries = hris_countries::where('del_status', 0)->sortBy('name')->get();
        return view('pages.recruitment.candidates.create', compact('candidate', 'jobPositions', 'countries'));
    }

    public function store(hris_candidates $candidate, Request $request)
    {
        if($this->storeValidatedData()) {
            if ( $request->hasFile('profile_image') ) {
                $imageName = time() . 'PI.' . $request->profile_image->extension();
                $candidate->profile_image = $imageName;
                $request->profile_image->move(public_path('assets/files/candidates/profile_image'), $imageName);
            }
            if($request->hasFile('resume')) {
                $resume = time() . 'R.' . $request->resume->extension();
                $candidate->resume = $resume;
                $request->resume->move(public_path('assets/files/candidates/resume'), $resume);
            }
            $candidate->job_position_id = request('job_position_id');
            $candidate->hiring_stage = request('hiring_stage');
            $candidate->first_name = request('first_name');
            $candidate->last_name = request('last_name');
            $candidate->gender = request('gender');
            $candidate->city = request('city');
            $candidate->country = request('country');
            $candidate->telephone = request('telephone');
            $candidate->email = request('email');
            $candidate->resume_headline = request('resume_headline');
            $candidate->profile_summary = request('profile_summary');
            $candidate->total_years_exp = request('total_years_exp');
            $candidate->work_history = request('work_history');
            $candidate->education = request('education');
            $candidate->skills = request('skills');
            $candidate->referees = request('referees');
            $candidate->prefered_industry = request('prefered_industry');
            $candidate->expected_salary = request('expected_salary');
            $candidate->del_status = 0;
            $candidate->save();
            $id = $candidate->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/candidates/index')->with('success','Candidate successfully added!');
        } else {
            return back()->withErrors($this->storeValidatedData());
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(hris_candidates $candidate)
    {
        $jobPositions = hris_job_positions::where('del_status', 0)->get();
        $countries = hris_countries::where('del_status', 0)->sortBy('name')->get();
        return view('pages.recruitment.candidates.edit', compact('candidate', 'countries', 'jobPositions'));
    }

    public function update(hris_candidates $candidate, Request $request)
    {
        $id = $candidate->id;
        if($this->updateValidatedData()) {
            $string = 'App\hris_candidates';
            if( $request->hasFile('profile_image') ) {
                $pathCandidate = public_path('/assets/files/candidates/profile_image/');
                if ($candidate->profile_image != '' && $candidate->profile_image != NULL) {
                    $old_file_1 = $pathCandidate . $candidate->profile_image;
                    unlink($old_file_1);
                    $imageName = time() . 'PI.' . $request->profile_image->extension();
                    $candidate->profile_image = $imageName;
                    $request->profile_image->move($pathCandidate, $imageName);
                } else {
                    $imageName = time() . 'PI.' . $request->profile_image->extension();
                    $candidate->profile_image = $imageName;
                    $request->profile_image->move($pathCandidate, $imageName);
                }
            }
            if( $request->hasFile('resume') ) {
                $pathResume = public_path('assets/files/candidates/resume/');
                if ($candidate->resume != '' && $candidate->resume != NULL) {
                    $old_file_2 = $pathResume . $candidate->resume;
                    unlink($old_file_2);
                    $resume = time() . 'R.' . $request->resume->extension();
                    $candidate->resume = $resume;
                    $request->resume->move($pathResume, $resume);
                } else {
                    $resume = time() . 'R.' . $request->resume->extension();
                    $candidate->resume = $resume;
                    $request->resume->move($pathResume, $resume);
                }
            }
            $attributes = array_keys($candidate->getAttributes());
            foreach ($attributes as $field) {
                if ( $field != 'id' AND $field != 'created_at' AND $field != 'updated_at' AND $field != 'resume' AND $field != 'profile_image' ) {
                    if ( $candidate->getOriginal($field) != request($field) ) {
                        $candidate->$field = request($field);
                    }
                }
            }
            // GET CHANGES
            $changes = $candidate->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $candidate->update();
            // GET CHANGES
            $changed = $candidate->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $candidate->wasChanged() ) {
                return redirect('/hris/pages/recruitment/candidates/index')->with('success','Candidate successfully updated!');
            } else {
                return redirect('/hris/pages/recruitment/candidates/index');
            }
        } else {
            return back()->withErrors($this->updateValidatedData());
        }

    }

    public function destroy(hris_candidates $candidate)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $candidate->del_status = 1;
                $candidate->update();
                $id = $candidate->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/candidates/index')->with('success','Candidate successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $candidate->del_status = 1;
                $candidate->update();
                $id = $candidate->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/recruitment/candidates/index')->with('success','Candidate successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }
    public function download(table_careers_application $candidate, Request $request)
    {
        if ($candidate->careers_app_file) {
            $file = public_path('assets/files/candidates/candidates_file/' . $candidate->careers_app_file);
            return response()->download($file);
        } else {
            return back()->withErrors(['File does not exist.']);
        }
    }

    public function updateStatus(Request $request){
        $candidate = hris_candidates::where('id',$request->candidate_id)->first();
        $candidate->status = $request->candidate_status;
        $candidate->update();
    }

    public function import()
    {
        if ($this->validateImport()) {
            Excel::import(new CandidateImport, request()->file('candidateData'));
            return redirect('/hris/pages/recruitment/candidates/index')->with('success', 'Candidate list successfully uploaded!');
        } else {
            return back()->withErrors(['Invalid file!']);
        }
    }

    protected function validateImport()
    {
        return request()->validate([
            'candidateData' => 'required|mimes:xlsx,xls',
        ]);
    }

    protected function storeValidatedData() {

        return request()->validate([

            'job_position_id'=>'required',
            'hiring_stage'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'profile_image'=>'nullable',
            'gender'=>'required',
            'city'=>'nullable',
            'country'=>'required',
            'telephone'=>'required',
            'email'=>'required',  
            'resume'=>'required',
            'resume_headline'=>'nullable',
            'profile_summary'=>'nullable',
            'total_years_exp'=>'nullable',
            'work_history'=>'nullable',
            'education'=>'nullable',
            'skills'=>'nullable',
            'referees'=>'nullable',
            'prefered_industry'=>'required',
            'expected_salary'=>'nullable'
        ]);

    }

    protected function updateValidatedData() {

        return request()->validate([

            'job_position_id'=>'required',
            'hiring_stage'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'profile_image'=>'nullable',
            'gender'=>'required',
            'city'=>'nullable',
            'country'=>'required',
            'telephone'=>'required',
            'email'=>'required',  
            'resume'=>'nullable',
            'resume_headline'=>'nullable',
            'profile_summary'=>'nullable',
            'total_years_exp'=>'nullable',
            'work_history'=>'nullable',
            'education'=>'nullable',
            'skills'=>'nullable',
            'referees'=>'nullable',
            'prefered_industry'=>'required',
            'expected_salary'=>'nullable'
        ]);

    }

}
