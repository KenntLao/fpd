<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_candidates;
use App\hris_job_positions;
use App\hris_countries;
use App\users;

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
        $candidates = hris_candidates::paginate(10);
        return view('pages.recruitment.candidates.index', compact('candidates'));
    }

    public function create(hris_candidates $candidate)
    {   
        $jobPositions = hris_job_positions::all();
        $countries = hris_countries::all()->sortBy('name');
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
        $jobPositions = hris_job_positions::all()->sortBy('job_title');
        $countries = hris_countries::all()->sortBy('name');
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
                    $imageName = time() . 'R.' . $request->profile_image->extension();
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
                }
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
            // GET CHANGES
            $changes = $benefit->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $benefit->update();
            // GET CHANGES
            $changed = $benefit->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $benefit->wasChanged() ) {
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
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $candidate->delete();
            $pathCandidate = public_path('assets/files/candidates/profile_image/');
            $pathResume = public_path('assets/files/candidates/resume/');
            if ($candidate->profile_image != '' && $candidate->profile_image != NULL) {
                $old_file_1 = $pathCandidate . $candidate->profile_image;
                unlink($old_file_1);
            }
            if ($candidate->resume != '' && $candidate->resume != NULL) {
                $old_file_2 = $pathResume . $candidate->resume;
                unlink($old_file_2);
            }
            $id = $candidate->id;
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/candidates/index')->with('success','Candidate successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
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
