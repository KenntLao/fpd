<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_company_structures;
use App\hris_countries;
use App\hris_time_zones;
use App\hris_company_types;

class CompanyController extends Controller
{

    public function index()
    {
        $companies = hris_company_structures::paginate(10);
        return view('pages.admin.company.index', compact('companies'));
    }

    public function create(hris_company_structures $company)
    {
        $countries = hris_countries::all()->sortBy('name');
        $types = hris_company_types::all();
        $timezones = hris_time_zones::all()->sortBy('name');
        $companies = hris_company_structures::all();
        return view('pages.admin.company.create', compact('company', 'companies', 'countries', 'timezones', 'types'));
    }

    public function store(Request $request)
    {

        $company = new hris_company_structures();

        if ( $this->validatedData() ) {
            $company->name = request('name');
            $company->details = request('details');
            $company->address = request('address');
            $company->type = request('type');
            $company->country = request('country');
            $company->timezone = request('timezone');
            $company->parent_structure = request('parent_structure');
            $company->save();
            return redirect('/hris/pages/admin/company/index')->with('success', 'Company Structure successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {

    }

    public function edit(hris_company_structures $company)
    {
        $types = hris_company_types::all();
        $countries = hris_countries::all();
        $timezones = hris_time_zones::all();
        $companies = hris_company_structures::all();
        return view('pages.admin.company.edit', compact('company', 'types', 'countries', 'timezones', 'companies'));
    }

    public function update(hris_company_structures $company, Request $request)
    {

        if ( $this->validatedData() ) {
            $company->name = request('name');
            $company->details = request('details');
            $company->address = request('address');
            $company->type = request('type');
            $company->country = request('country');
            $company->timezone = request('timezone');
            $company->parent_structure = request('parent_structure');
            $company->update();
            return redirect('/hris/pages/admin/company/index')->with('success', 'Company Structure successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function destroy(hris_company_structures $company)
    {

        $company->delete();
        return redirect('/hris/pages/admin/company/index')->with('success', 'Company Structure successfully deleted');

    }

    protected function validatedData() {

        return request()->validate([

            'name'=>'required',
            'details'=>'required',
            'type'=>'required',
            'country'=>'required',
            'timezone'=>'required',
            'parent_structure'=>'required'

        ]);

    }
}
