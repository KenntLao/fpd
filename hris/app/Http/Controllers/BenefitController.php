<?php

namespace App\Http\Controllers;

use App\hris_benefits;
use Illuminate\Http\Request;

class BenefitController extends Controller
{
    public function index()
    {   
        $benefits = hris_benefits::paginate(10);
        return view('pages.recruitment.recruitmentSetup.benefits.index', compact('benefits'));
    }

    public function create(hris_benefits $benefit)
    {
        return view('pages.recruitment.recruitmentSetup.benefits.create');
    }

    public function store(Request $request)
    {

        $benefit = new hris_benefits();

        if ($this->validatedData()) {
            $benefit->name = request('name');
            $benefit->save();
            return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success', 'Benefit successfully added!');
        } else {
            return back()->withErrors($this->validatedData);
        }

    }

    public function show($id)
    {
        //
    }

    public function edit(hris_benefits $benefit)
    {
        return view('pages.recruitment.recruitmentSetup.benefits.edit', compact('benefit'));
    }


    public function update(hris_benefits $benefit, Request $request)
    {
        if ($this->validatedData()) {
            $benefit->name = request('name');
            $benefit->update();
            return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success', 'Benefit successfully updated!');
        } else {
            return back()->withErrors($this->validatedData);
        } 
    }


    public function destroy(hris_benefits $benefit)
    {
        $benefit->delete();

        return redirect('/hris/pages/recruitment/recruitmentSetup/benefits/index')->with('success','Benefit successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}