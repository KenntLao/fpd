<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_certifications;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = hris_certifications::paginate(10);
        return view('pages.admin.qualifications.certifications.index', compact('certifications'));
    }

    public function create(hris_certifications $certification)
    {
        return view('pages.admin.qualifications.certifications.create', compact('certification'));
    }

    public function store(Request $request)
    {
        $certification = new hris_certifications();
        if($this->validatedData()) {
            $certification->name = request('name');
            $certification->description = request('description');
            $certification->save();
            return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_certifications $certification)
    {
        return view('pages.admin.qualifications.certifications.edit', compact('certification'));
    }

    public function update(hris_certifications $certification, Request $request)
    {
        if($this->validatedData()) {
            $certification->name = request('name');
            $certification->description = request('description');
            $certification->update();
            return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_certifications $certification)
    {
        $certification->delete();
        return redirect('/hris/pages/admin/qualifications/certifications/index')->with('success', 'Certification successfully deleted!');
    }

    protected function validatedData() 
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'required'
        ]);
    }

}
