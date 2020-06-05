<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_company_structures;
use App\hris_countries;
use App\hris_time_zones;
use App\users;

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
        $timezones = hris_time_zones::all()->sortBy('name');
        $companies = hris_company_structures::all();
        return view('pages.admin.company.create', compact('company', 'companies', 'countries', 'timezones'));
    }

    public function store(hris_company_structures $company, Request $request)
    {
        if ( $this->validatedData() ) {
            $company::create($this->validatedData());
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

        if ( $this->validatedData() ) {
            $company->update($this->validatedData());
            return redirect('/hris/pages/admin/company/index')->with('success', 'Company structure successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }

    }

    public function destroy(hris_company_structures $company)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $company->delete();
            return redirect('/hris/pages/admin/company/index')->with('success', 'Company structure successfully deleted');
        } else {
            return back()->withErrors(['Password does not match.']);
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
    // decrypt string
    function decryptStr($str) {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c,0,$ivlen);
        $hmac = substr($c,$ivlen,$sha2len=32);
        $ciphertext_raw = substr($c,$ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw,$cipher,$key,$options=OPENSSL_RAW_DATA,$iv);
        $calcmac = hash_hmac('sha256',$ciphertext_raw,$key,$as_binary=true);
        if (hash_equals($hmac,$calcmac)) { return $original_plaintext; }
    }
}
