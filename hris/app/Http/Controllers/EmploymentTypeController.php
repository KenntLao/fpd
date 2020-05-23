<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employment_types;

class EmploymentTypeController extends Controller
{
    public function index()
    {
        $employmentTypes = hris_employment_types::paginate(10);
        return view('pages.recruitment.recruitmentSetup.employmentTypes.index', compact('employmentTypes'));
    }

    public function create(hris_employment_types $employmentType)
    {
        return view('pages.recruitment.recruitmentSetup.employmentTypes.create');
    }

    public function store(Request $request)
    {
        $employmentType = new hris_employment_types();

        if ($this->validatedData()) {
            $employmentType->name = request('name');
            $employmentType->save();
            return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success', 'Employment type successfully added!');
        } else {
            return back()->withErrors($this->validatedData);
        }


    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $employmentType = hris_employment_types::find($id);
        return view('pages.recruitment.recruitmentSetup.employmentTypes.edit', compact('employmentType'));
    }

    public function update(hris_employment_types $employmentType, Request $request)
    {
        if ($this->validatedData()) {
            $employmentType->name = request('name');
            $employmentType->update();
            return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success', 'Employment type successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }

    public function destroy(hris_employment_types $employmentType)
    {
        $employmentType->delete();
        return redirect('/hris/pages/recruitment/recruitmentSetup/employmentTypes/index')->with('success','Employment type successfully deleted!');
    }


    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}
