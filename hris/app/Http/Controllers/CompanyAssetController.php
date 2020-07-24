<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_employee;
use App\hris_company_asset_types;
use App\hris_company_assets;
use App\users;

class CompanyAssetController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Company Assets - Asset';
    }
    public function index()
    {
        $assets = hris_company_assets::paginate(10);
        return view('pages.admin.companyAssets.assets.index', compact('assets'));
    }

    public function create(hris_company_assets $asset)
    {
        $employees = hris_employee::all();
        $types = hris_company_asset_types::all();
        return view('pages.admin.companyAssets.assets.create', compact('asset', 'employees', 'types'));
    }

    public function store(hris_company_assets $asset, Request $request)
    {
        if($this->validatedData()) {
            $asset = hris_company_assets::create($this->validatedData());
            $id = $asset->id;
            $this->function->addSystemLog($this->module,$id);
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
        $types = hris_company_asset_types::all();
        return view('pages.admin.companyAssets.assets.edit', compact('asset', 'employees', 'types'));
    }

    public function update(hris_company_assets $asset, Request $request)
    {
        $id = $asset->id;
        if($this->validatedData()) {
            $string = 'App\hris_company_assets';
            $asset->code = request('code');
            $asset->asset_type_id = request('asset_type_id');
            $asset->employee_id = request('employee_id');
            $asset->description = request('description');
            // GET CHANGES
            $changes = $asset->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $asset->update();
            // GET CHANGES
            $changed = $asset->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $asset->wasChanged() ) {
                return redirect('/hris/pages/admin/companyAssets/assets/index')->with('success', 'Company asset successfully updated!');
            } else {
                return redirect('/hris/pages/admin/companyAssets/assets/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_company_assets $asset)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $asset->delete();
                $id = $asset->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/companyAssets/assets/index')->with('success','Company asset successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $asset->delete();
                $id = $asset->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/companyAssets/assets/index')->with('success','Company asset successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'code' => 'required',
            'asset_type_id' => 'required',
            'employee_id' => 'nullable',
            'description' => 'required',
        ]);
    }
}
