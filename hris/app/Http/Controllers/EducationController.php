<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_educations;

class EducationController extends Controller
{
    public function index()
    {
        $educations = hris_educations::paginate(10);
        return view('pages.admin.qualifications.educations.index', compact('educations'));
    }

    public function create(hris_educations $education)
    {
        return view('pages.admin.qualifications.educations.create', compact('education'));
    }

    public function store(Request $request)
    {
        $education = new hris_educations();
        if($this->validatedData()) {
            $education->name = request('name');
            $education->description = request('description');
            $education->save();
            return redirect('/pages/admin/qualifications/educations/index')->with('success', 'Education successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_educations $education)
    {
        return view('pages.admin.qualifications.educations.edit', compact('education'));
    }

    public function update(hris_educations $education, Request $request)
    {
        if($this->validatedData()) {
            $education->name = request('name');
            $education->description = request('description');
            $education->update();
            return redirect('/pages/admin/qualifications/educations/index')->with('success', 'Education successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_educations $education)
    {
        $education->delete();
        return redirect('/pages/admin/qualifications/educations/index')->with('success', 'Education successfully deleted!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    }

}
