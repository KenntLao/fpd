<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_education_levels;

class EducationLevelController extends Controller
{

    public function index()
    {   
        $educationLevels = hris_education_levels::paginate(10);
        return view('pages.recruitment.recruitmentSetup.educationLevels.index', compact('educationLevels'));
    }

    public function create(hris_education_levels $educationLevel)
    {
        return view('pages.recruitment.recruitmentSetup.educationLevels.create', compact('educationLevel'));
    }

    public function store(Request $request)
    {
        $educationLevel = new hris_education_levels();

        if ($this->validatedData()) {
            $educationLevel->name = request('name');
            $educationLevel->save();
            Log::channel('educationLevels')->info('A new education level has been added. Id: ' .$educationLevel->id. '. Name: '. $educationLevel->name. '.');
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully added!');
        } else {
            return back()->withErrors($this->validatedData);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(hris_education_levels $educationLevel)
    {
        return view('pages.recruitment.recruitmentSetup.educationLevels.edit', compact('educationLevel'));
    }

    public function update(hris_education_levels $educationLevel, Request $request)
    {
        if ($this->validatedData()) {
            $educationLevel->name = request('name');
            $educationLevel->update();
            Log::channel('educationLevels')->info('Education level id no.' .$educationLevel->id. ' has been updated. Name: '. $educationLevel->name. '.');
            return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success', 'Education level successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }

    public function destroy(hris_education_levels $educationLevel)
    {
        $educationLevel->delete();
        Log::channel('educationLevels')->info('Education level id no.' .$educationLevel->id. ' has been deleted. Name: '. $educationLevel->name. '.');
        return redirect('/hris/pages/recruitment/recruitmentSetup/educationLevels/index')->with('success','Education level successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}
