<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_company_structures;
use App\hris_countries;
use App\hris_time_zones;
use App\users;

class CompanyController extends Controller
{

    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Administration - Company Structure';
    }

    public function index()
    {
        $companies = hris_company_structures::paginate(10);
        return view('pages.admin.company.index', compact('companies'));
    }

    public function create(hris_company_structures $company)
    {
        $countries = hris_countries::all()->sortBy('name');
        $timezones = hris_time_zones::all()->sortBy('name');
        $companies = hris_company_structures::all();
        return view('pages.admin.company.create', compact('company', 'companies', 'countries', 'timezones'));
    }

    public function store(hris_company_structures $company, Request $request)
    {
        if ( $this->validatedData() ) {
            $company = hris_company_structures::create($this->validatedData());
            $id = $company->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/company/index')->with('success', 'Company structure successfully added!');

        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function show($id)
    {

    }

    public function edit(hris_company_structures $company)
    {
        $countries = hris_countries::all();
        $timezones = hris_time_zones::all();
        $companies = hris_company_structures::all();
        return view('pages.admin.company.edit', compact('company', 'countries', 'timezones', 'companies'));
    }

    public function update(hris_company_structures $company, Request $request)
    {
        $id = $company->id;
        if ( $this->validatedData() ) {
            $string = 'App\hris_company_structures';
            $company->name = request('name');
            $company->details = request('details');
            $company->address = request('address');
            $company->type = request('type');
            $company->country = request('country');
            $company->timezone = request('timezone');
            $company->parent_structure = request('parent_structure');
            // GET CHANGES
            $changes = $company->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $company->update();
            // GET CHANGES
            $changed = $company->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $company->wasChanged() ) {
                return redirect('/hris/pages/admin/company/index')->with('success', 'Company structure successfully updated!');
            } else {
                return redirect('/hris/pages/admin/company/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function destroy(hris_company_structures $company)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $company->delete();
                $id = $company->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/company/index')->with('success', 'Company structure successfully deleted');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $company->delete();
                $id = $company->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/company/index')->with('success', 'Company structure successfully deleted');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }

    }

    protected function validatedData() {

        return request()->validate([

            'name'=>'required',
            'details'=>'required',
            'address'=>'nullable',
            'type'=>'required',
            'country'=>'required',
            'timezone'=>'required',
            'parent_structure'=>'nullable'

        ]);

    }
}
