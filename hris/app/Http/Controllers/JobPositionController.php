<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_job_positions;
use App\hris_benefits;
use App\hris_employment_types;
use App\hris_education_levels;
use App\hris_experience_levels;
use App\hris_job_functions;
use App\hris_job_titles;
use App\hris_countries;
use App\hris_currencies;
use App\users;
use App\hris_company_structures;

class JobPositionController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Recruitment Setup - Job Position';
    }

    public function index()
    {
        $jobPositions = hris_job_positions::paginate(10);

        return view('pages.recruitment.jobPositions.index', compact('jobPositions'));
    }

    public function create(hris_job_positions $jobPosition)
    {
        $benefits = hris_benefits::all();
        $employmentTypes = hris_employment_types::all();
        $educationLevels = hris_education_levels::all();
        $experienceLevels = hris_experience_levels::all();
        $jobFunctions = hris_job_functions::all();
        $jobTitles = hris_job_titles::all();
        $countries = hris_countries::all()->sortBy('name');
        $currencies = hris_currencies::all()->sortBy('name');
        $departments = hris_company_structures::all();
        return view('pages.recruitment.jobPositions.create', compact('benefits','employmentTypes', 'educationLevels', 'experienceLevels', 'jobFunctions', 'countries', 'currencies', 'jobPosition', 'departments', 'jobTitles'));
    }

    public function store(hris_job_positions $jobPosition, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            if( $request->hasFile('image') ) {
                $imageName = time() . '.' . $request->image->extension();
                $jobPosition->image = $imageName;
                $request->image->move(public_path('assets/images/job_positions/'), $imageName);
            }
            $jobPosition->job_title_id = request('job_title_id');
            $jobPosition->company_name = request('company_name');
            $jobPosition->hiring_manager = request('hiring_manager');
            $jobPosition->show_hiring_manager_name = request('show_hiring_manager_name');
            $jobPosition->short_description = request('short_description');
            $jobPosition->requirements = request('requirements');
            $jobPosition->benefit_id = request('benefit_id');
            $jobPosition->country = request('country');
            $jobPosition->city = request('city');
            $jobPosition->postal_code = request('postal_code');
            $jobPosition->department_id = request('department_id');
            $jobPosition->employment_type_id = request('employment_type_id');
            $jobPosition->exp_level_id = request('exp_level_id');
            $jobPosition->job_function_id = request('job_function_id');
            $jobPosition->education_level_id = request('education_level_id');
            $jobPosition->show_salary = request('show_salary');
            $jobPosition->currency = request('currency');
            $jobPosition->salary_min = request('salary_min');
            $jobPosition->salary_max = request('salary_max');
            $jobPosition->keywords = request('keywords');
            $jobPosition->status = request('status');
            $jobPosition->closing_date = request('closing_date');
            $jobPosition->display_type = request('display_type');
            $id = $jobPosition->id;
            $this->function->systemLog($this->module,$action,$id);
            $jobPosition->save();
            return redirect('/hris/pages/recruitment/jobPositions/index')->with('success','Job position successfully added!');
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
        $jobTitles = hris_job_titles::all();
        $countries = hris_countries::all()->sortBy('name');
        $currencies = hris_currencies::all()->sortBy('name');
        $departments = hris_company_structures::all();
        return view('pages.recruitment.jobPositions.edit', compact('jobPosition','benefits','employmentTypes', 'educationLevels', 'experienceLevels', 'jobFunctions','countries', 'currencies', 'departments','jobTitles'));
    }

    public function update(hris_job_positions $jobPosition, Request $request)
    {
        $id = $jobPosition->id;
        if ($this->validatedData()) {
            $model = $jobPosition;
            if ( $request->hasFile('image') ) {
                $imagePath = public_path('assets/images/job_positions/');
                if ($jobPosition->image != '' && $jobPosition->image != NULL) {
                    $old_file = $imagePath . $jobPosition->image;
                    unlink($old_file);
                    $imageName = time() . '.' . $request->image->extension();
                    $jobPosition->image = $imageName;
                    $request->image->move(public_path('assets/images/job_positions/'), $imageName);
                } else {
                    $imageName = time() . '.' . $request->image->extension();
                    $jobPosition->image = $imageName;
                    $request->image->move(public_path('assets/images/job_positions/'), $imageName);
                }
            }
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $jobPosition->job_title_id = request('job_title_id');
            $jobPosition->company_name = request('company_name');
            $jobPosition->hiring_manager = request('hiring_manager');
            $jobPosition->show_hiring_manager_name = request('show_hiring_manager_name');
            $jobPosition->short_description = request('short_description');
            $jobPosition->requirements = request('requirements');
            $jobPosition->benefit_id = request('benefit_id');
            $jobPosition->country = request('country');
            $jobPosition->city = request('city');
            $jobPosition->postal_code = request('postal_code');
            $jobPosition->department_id = request('department_id');
            $jobPosition->employment_type_id = request('employment_type_id');
            $jobPosition->exp_level_id = request('exp_level_id');
            $jobPosition->job_function_id = request('job_function_id');
            $jobPosition->education_level_id = request('education_level_id');
            $jobPosition->show_salary = request('show_salary');
            $jobPosition->currency = request('currency');
            $jobPosition->salary_min = request('salary_min');
            $jobPosition->salary_max = request('salary_max');
            $jobPosition->keywords = request('keywords');
            $jobPosition->status = request('status');
            $jobPosition->closing_date = request('closing_date');
            $jobPosition->display_type = request('display_type');
            $jobPosition->update();
            return redirect('/hris/pages/recruitment/jobPositions/index')->with('success','Job position successfully updated!');

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_job_positions $jobPosition)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $imagePath = public_path('assets/images/job_positions/');
            $jobPosition->delete();
            if ($jobPosition->image != '' && $jobPosition->image != NULL) {
                $old_file = $imagePath . $jobPosition->image;
                unlink($old_file);
            }
            $id = $jobPosition->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/recruitment/jobPositions/index')->with('success','Job position successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'job_title_id'=>'required',
            'show_hiring_manager_name'=>'required',
            'short_description'=>'required',
            'benefit_id'=>'required',
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
