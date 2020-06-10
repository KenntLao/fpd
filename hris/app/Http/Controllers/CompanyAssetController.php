<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_employee;
use App\hris_company_structures;
use App\hris_company_asset_types;
use App\hris_company_assets;
use App\users;

class CompanyAssetController extends Controller
{

    public function index()
    {
        $assets = hris_company_assets::paginate(10);
        return view('pages.admin.companyAssets.assets.index', compact('assets'));
    }

    public function create(hris_company_assets $asset)
    {
        $employees = hris_employee::all();
        $departments = hris_company_structures::all();
        $types = hris_company_asset_types::all();
        return view('pages.admin.companyAssets.assets.create', compact('asset', 'employees', 'departments', 'types'));
    }

    public function store(hris_company_assets $asset, Request $request)
    {
        if($this->validatedData()) {
            $asset::create($this->validatedData());
            return redirect('/hris/pages/admin/companyAssets/assets/index')->with('success', 'Company asset successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_company_assets $asset)
    {
        $employees = hris_employee::all();
        $departments = hris_company_structures::all();
        $types = hris_company_asset_types::all();
        return view('pages.admin.companyAssets.assets.edit', compact('asset', 'employees', 'departments', 'types'));
    }

    public function update(hris_company_assets $asset, Request $request)
    {
        if($this->validatedData()) {
            $asset->update($this->validatedData());
            return redirect('/hris/pages/admin/companyAssets/assets/index')->with('success', 'Company asset successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_company_assets $asset)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $asset->delete();
            return redirect('/hris/pages/admin/companyAssets/assets/index')->with('success','Company asset successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'code' => 'required',
            'type_id' => 'required',
            'employee_id' => 'nullable',
            'department_id' => 'nullable',
            'description' => 'required',
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
