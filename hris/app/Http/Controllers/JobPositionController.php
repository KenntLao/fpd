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
        if ($this->validatedData()) {
            $attributes = \Schema::getColumnListing($jobPosition->getTable());
            if( $request->hasFile('image') ) {
                $imageName = time() . 'IMG.' . $request->image->extension();
                $jobPosition->image = $imageName;
                $request->image->move(public_path('assets/images/job_positions/'), $imageName);
            }
            foreach ($attributes as $field) {
                if ( $field != 'id' AND $field != 'created_at' AND $field != 'updated_at' AND $field != 'image' ) {
                    if ( $jobPosition->getOriginal($field) != request($field) ) {
                        $jobPosition->$field = request($field);
                    }
                }
            }
            $id = $jobPosition->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_job_positions';
            $attributes = array_keys($jobPosition->getAttributes());
            if( $request->hasFile('image') ) {
                $path = public_path('assets/images/job_positions/');
                if ($jobPosition->image != '' && $jobPosition->image != NULL) {
                    $old = $path . $jobPosition->image;
                    unlink($old);
                    $image = time() . 'IMG.' . $request->image->extension();
                    $jobPosition->image = $image;
                    $request->image->move($path, $image);
                } else {
                    $image = time() . 'IMG.' . $request->image->extension();
                    $jobPosition->image = $image;
                    $request->image->move($path, $image);
                }
            }
            foreach ($attributes as $field) {
                if ( $field != 'id' AND $field != 'created_at' AND $field != 'updated_at' AND $field != 'image' ) {
                    if ( $jobPosition->getOriginal($field) != request($field) ) {
                        $jobPosition->$field = request($field);
                    }
                }
            }
            // GET CHANGES
            $changes = $jobPosition->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $jobPosition->update();
            // GET CHANGES
            $changed = $jobPosition->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $jobPosition->wasChanged() ) {
                return redirect('/hris/pages/recruitment/jobPositions/index')->with('success','Job position successfully updated!');
            } else {
                return redirect('/hris/pages/recruitment/jobPositions/index');
            }

        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_job_positions $jobPosition)
    {
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
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/recruitment/jobPositions/index')->with('success','Job position successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData() 
    {
        return request()->validate([
            'job_title_id'=>'required',
            'company_name'=>'nullable',
            'hiring_manager'=>'nullable',
            'show_hiring_manager_name'=>'required',
            'short_description'=>'required',
            'requirements'=>'nullable',
            'benefit_id'=>'required',
            'country'=>'required',
            'city'=>'required',
            'postal_code'=>'required',
            'department_id'=>'nullable',
            'employment_type_id'=>'nullable',
            'exp_level_id'=>'nullable',
            'job_function_id'=>'nullable',
            'education_level_id'=>'nullable',
            'show_salary'=>'required',
            'currency'=>'required',
            'salary_min'=>'nullable',
            'salary_max'=>'nullable',
            'keywords'=>'nullable',
            'status'=>'required',
            'closing_date'=>'nullable',
            'image'=>'nullable',
            'display_type'=>'required'
        ]);
    }

}
