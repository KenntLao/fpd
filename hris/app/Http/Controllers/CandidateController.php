<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_candidates;
use App\hris_job_positions;
use App\hris_countries;
use App\users;

class CandidateController extends Controller
{

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

    public function store(Request $request)
    {

        $candidate = new hris_candidates();
        if($this->validatedData() && $request->hasFile('resume')) {
            if ( $request->hasFile('profile_image') ) {
                $imageName = time() . '.' . $request->profile_image->extension();
                $candidate->profile_image = $imageName;
                $request->profile_image->move(public_path('assets/files/candidates/profile_image'), $imageName);
            }
            $resume = time() . '.' . $request->resume->extension();
            $candidate->position_applied = request('position_applied');
            $candidate->hiring_stage = request('hiring_stage');
            $candidate->first_name = request('first_name');
            $candidate->last_name = request('last_name');
            $candidate->gender = request('gender');
            $candidate->city = request('city');
            $candidate->country = request('country');
            $candidate->telephone = request('telephone');
            $candidate->email = request('email');
            $candidate->resume = $resume;
            $candidate->resume_headline = request('resume_headline');
            $candidate->profile_summary = request('profile_summary');
            $candidate->total_years_exp = request('total_years_exp');
            $candidate->work_history = request('work_history');
            $candidate->education = request('education');
            $candidate->skills = request('skills');
            $candidate->referees = request('referees');
            $candidate->prefered_industry = request('prefered_industry');
            $candidate->expected_salary = request('expected_salary');
            $request->resume->move(public_path('assets/files/candidates/resume'), $resume);
            $candidate->save();
            return redirect('/hris/pages/recruitment/candidates/index')->with('success','Candidate successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
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

        if($this->validatedData()) {
            if( $request->hasFile('profile_image') ) {
                $pathCandidate = public_path('/assets/files/candidates/profile_image/');
                if ($candidate->profile_image != '' && $candidate->profile_image != NULL) {
                    $old_file_1 = $pathCandidate . $candidate->profile_image;
                    unlink($old_file_1);
                    $imageName = time() . '.' . $request->profile_image->extension();
                    $candidate->profile_image = $imageName;
                    $request->profile_image->move(public_path('/assets/files/candidates/profile_image/'), $imageName);
                } else {
                    $imageName = time() . '.' . $request->profile_image->extension();
                    $candidate->profile_image = $imageName;
                    $request->profile_image->move(public_path('/assets/files/candidates/profile_image/'), $imageName);
                }
            }
            if( $request->hasFile('resume') ) {
                $pathResume = public_path('assets/files/candidates/resume/');
                if ($candidate->resume != '' && $candidate->resume != NULL) {
                    $old_file_2 = $pathResume . $candidate->resume;
                    unlink($old_file_2);
                    $resume = time() . '.' . $request->resume->extension();
                    $candidate->resume = $resume;
                    $request->resume->move(public_path('assets/files/candidates/resume/'), $resume);
                } else {
                    $resume = time() . '.' . $request->resume->extension();
                    $candidate->resume = $resume;
                    $request->resume->move(public_path('assets/files/candidates/resume/'), $resume);
                }
            }
            $candidate->position_applied = request('position_applied');
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
            $candidate->update();
            return redirect('/hris/pages/recruitment/candidates/index')->with('success','Candidate successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function destroy(hris_candidates $candidate)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
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
            return redirect('/hris/pages/recruitment/candidates/index')->with('success','Candidate successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() {

        return request()->validate([

            'position_applied'=>'required',
            'hiring_stage'=>'required',
            'first_name'=>'required',
            'last_name'=>'required',
            'gender'=>'required',
            'country'=>'required',
            'telephone'=>'required',
            'email'=>'required',  
            'prefered_industry'=>'required'
        ]);

    }
    // decrypt string
    function decryptStr($str) {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c,0,$ivlen);
        $hmac = substr($c,$ivlen,$sha2len=32);
        $ciphertext_raw = substr($c,$ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw,$cipher,$key,$options=OPENSSL_RAW_DATA,$iv);
        $calcmac = hash_hmac('sha256',$ciphertext_raw,$key,$as_binary=true);
        if (hash_equals($hmac,$calcmac)) { return $original_plaintext; }
    }

}
