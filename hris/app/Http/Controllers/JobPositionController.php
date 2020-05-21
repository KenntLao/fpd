<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_job_positions;
use App\hris_benefits;
use App\hris_employment_types;
use App\hris_education_levels;
use App\hris_experience_levels;
use App\hris_job_functions;
use App\hris_countries;
use App\hris_currencies;

class JobPositionController extends Controller
{

    public function index()
    {
        $jobPositions = hris_job_positions::paginate(10);

        return view('pages.recruitment.jobPositions.index', compact('jobPositions'));
    }

    public function create()
    {
        $benefits = hris_benefits::all();
        $employmentTypes = hris_employment_types::all();
        $educationLevels = hris_education_levels::all();
        $experienceLevels = hris_experience_levels::all();
        $jobFunctions = hris_job_functions::all();
        $countries = hris_countries::all()->sortBy('name');
        $currencies = hris_currencies::all()->sortBy('name');
        return view('pages.recruitment.jobPositions.create', compact('benefits','employmentTypes', 'educationLevels', 'experienceLevels', 'jobFunctions', 'countries', 'currencies'));
    }

    public function store(Request $request)
    {
        $jobPosition = new hris_job_positions();
        if ($request->hasFile('image')) {
            if ($this->validatedData()) {
                $imageName = time() . '.' . $request->image->extension();
                $jobPosition->job_code = request('job_code');
                $jobPosition->job_title = request('job_title');
                $jobPosition->company_name = request('company_name');
                $jobPosition->hiring_manager = request('hiring_manager');
                $jobPosition->show_hiring_manager_name = request('show_hiring_manager_name');
                $jobPosition->short_description = request('short_description');
                $jobPosition->job_description = request('job_description');
                $jobPosition->requirements = request('requirements');
                $jobPosition->benefits = request('benefits');
                $jobPosition->country = request('country');
                $jobPosition->city = request('city');
                $jobPosition->postal_code = request('postal_code');
                $jobPosition->department = request('department');
                $jobPosition->employment_type = request('employment_type');
                $jobPosition->exp_level = request('exp_level');
                $jobPosition->job_function = request('job_function');
                $jobPosition->education_level = request('education_level');
                $jobPosition->show_salary = request('show_salary');
                $jobPosition->currency = request('currency');
                $jobPosition->salary_min = request('salary_min');
                $jobPosition->salary_max = request('salary_max');
                $jobPosition->keywords = request('keywords');
                $jobPosition->status = request('status');
                $jobPosition->closing_date = request('closing_date');
                $jobPosition->image = $imageName;
                $jobPosition->display_type = request('display_type');
                $jobPosition->save();
                $request->image->move(public_path('assets/images/job_positions/'), $imageName);
                return redirect('/pages/recruitment/jobPositions/index')->with('success','Job position successfully added!');
            } else {
                return back()->withErrors($this->validatedData());
            }
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {
        //
    }

    public function edit(hris_job_positions $jobPosition)
    {
        $benefits = hris_benefits::all();
        $employmentTypes = hris_employment_types::all();
        $educationLevels = hris_education_levels::all();
        $experienceLevels = hris_experience_levels::all();
        $jobFunctions = hris_job_functions::all();
        $countries = hris_countries::all()->sortBy('name');
        $currencies = hris_currencies::all()->sortBy('name');
        return view('pages.recruitment.jobPositions.edit', compact('jobPosition','benefits','employmentTypes', 'educationLevels', 'experienceLevels', 'jobFunctions','countries', 'currencies'));
    }

    public function update(hris_job_positions $jobPosition, Request $request)
    {
        if ($request->hasFile('image')) {
            if ($this->validatedData()) {
                $imagePath = public_path('assets/images/job_positions/');
                if ($jobPosition->image != '' && $jobPosition->image != NULL) {
                    $old_file = $imagePath . $jobPosition->image;
                    unlink($old_file);
                }
                $imageName = time() . '.' . $request->image->extension();
                $jobPosition->job_code = request('job_code');
                $jobPosition->job_title = request('job_title');
                $jobPosition->company_name = request('company_name');
                $jobPosition->hiring_manager = request('hiring_manager');
                $jobPosition->show_hiring_manager_name = request('show_hiring_manager_name');
                $jobPosition->short_description = request('short_description');
                $jobPosition->job_description = request('job_description');
                $jobPosition->requirements = request('requirements');
                $jobPosition->benefits = request('benefits');
                $jobPosition->country = request('country');
                $jobPosition->city = request('city');
                $jobPosition->postal_code = request('postal_code');
                $jobPosition->department = request('department');
                $jobPosition->employment_type = request('employment_type');
                $jobPosition->exp_level = request('exp_level');
                $jobPosition->job_function = request('job_function');
                $jobPosition->education_level = request('education_level');
                $jobPosition->show_salary = request('show_salary');
                $jobPosition->currency = request('currency');
                $jobPosition->salary_min = request('salary_min');
                $jobPosition->salary_max = request('salary_max');
                $jobPosition->keywords = request('keywords');
                $jobPosition->status = request('status');
                $jobPosition->closing_date = request('closing_date');
                $jobPosition->image = $imageName;
                $jobPosition->display_type = request('display_type');
                $jobPosition->update();
                $request->image->move(public_path('assets/images/job_positions/'), $imageName);
                return redirect('/pages/recruitment/jobPositions/index')->with('success','Job position successfully updated!');

            } else {
                return back()->withErrors($this->validatedData());
            }
        } else {
            if ($this->validatedData()) {
                $jobPosition->job_code = request('job_code');
                $jobPosition->job_title = request('job_title');
                $jobPosition->company_name = request('company_name');
                $jobPosition->hiring_manager = request('hiring_manager');
                $jobPosition->show_hiring_manager_name = request('show_hiring_manager_name');
                $jobPosition->short_description = request('short_description');
                $jobPosition->job_description = request('job_description');
                $jobPosition->requirements = request('requirements');
                $jobPosition->benefits = request('benefits');
                $jobPosition->country = request('country');
                $jobPosition->city = request('city');
                $jobPosition->postal_code = request('postal_code');
                $jobPosition->department = request('department');
                $jobPosition->employment_type = request('employment_type');
                $jobPosition->exp_level = request('exp_level');
                $jobPosition->job_function = request('job_function');
                $jobPosition->education_level = request('education_level');
                $jobPosition->show_salary = request('show_salary');
                $jobPosition->currency = request('currency');
                $jobPosition->salary_min = request('salary_min');
                $jobPosition->salary_max = request('salary_max');
                $jobPosition->keywords = request('keywords');
                $jobPosition->status = request('status');
                $jobPosition->closing_date = request('closing_date');
                $jobPosition->display_type = request('display_type');
                $jobPosition->update();
                return redirect('/pages/recruitment/jobPositions/index')->with('success','Job position successfully updated!');
            } else {
                return back()->withErrors($this->validatedData());
            }
        }
    }

    public function destroy(hris_job_positions $jobPosition)
    {
        $imagePath = public_path('assets/images/job_positions/');
        $jobPosition->delete();
        if ($jobPosition->image != '' && $jobPosition->image != NULL) {
            $old_file = $imagePath . $jobPosition->image;
            unlink($old_file);
        }
        return redirect('/pages/recruitment/jobPositions/index')->with('success','Job position successfully deleted!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'job_code'=>'required',
            'job_title'=>'required',
            'show_hiring_manager_name'=>'required',
            'short_description'=>'required',
            'job_description'=>'required',
            'benefits'=>'required',
            'country'=>'required',
            'city'=>'required',
            'postal_code'=>'required',
            'show_salary'=>'required',
            'currency'=>'required',
            'status'=>'required',
            'display_type'=>'required'
        ]);
    }
}
