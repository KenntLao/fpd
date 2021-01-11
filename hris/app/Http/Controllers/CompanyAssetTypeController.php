<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_asset_types;
use App\users;

class CompanyAssetTypeController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Company Assets - Asset Type';
    }
    public function index()
    {
        $types = hris_company_asset_types::where('del_status', 0)->paginate(10);
        return view('pages.admin.companyAssets.types.index', compact('types'));
    }

    public function create(hris_company_asset_types $type)
    {
        return view('pages.admin.companyAssets.types.create', compact('type'));
    }

    public function store(hris_company_asset_types $type, Request $request)
    {
        if($this->validatedData()) {
            if( $request->hasFile('attachment') ) {
                $attachment = time() . 'A.' . $request->attachment->extension();
                $type->attachment = $attachment;
                $request->attachment->move(public_path('assets/files/companyAssets/types/'), $attachment);
            }
            $type->name = request('name');
            $type->description = request('description');
            $type->del_status = 0;
            $type->save();
            $id = $type->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/companyAssets/types/index')->with('success', 'Asset type successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_company_asset_types $type)
    {
        return view('pages.admin.companyAssets.types.edit', compact('type'));
    }

    public function update(hris_company_asset_types $type, Request $request)
    {
        $id = $type->id;
        if($this->validatedData()) {
            $string = 'App\hris_company_asset_types';
            if( $request->hasFile('attachment') ) {
            $path = public_path('/assets/files/companyAssets/types/');
                if ($type->attachment != '' && $type->attachment != NULL) {
                    $old_file_1 = $path . $type->attachment;
                    unlink($old_file_1);
                    $attachment = time() . 'A.' . $request->attachment->extension();
                    $type->attachment = $attachment;
                    $request->attachment->move($path, $attachment);
                } else {
                    $attachment = time() . 'A.' . $request->attachment->extension();
                    $type->attachment = $attachment;
                    $request->attachment->move($path, $attachment);
                }
            }
            $type->name = request('name');
            $type->description = request('description');
            // GET CHANGES
            $changes = $type->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $type->update();
            // GET CHANGES
            $changed = $type->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $type->wasChanged() ) {
                return redirect('/hris/pages/admin/companyAssets/types/index')->with('success', 'Asset type successfully updated!');
            } else {
                return redirect('/hris/pages/admin/companyAssets/types/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_company_asset_types $type)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $type->del_status = 1;
                $type->update();
                $id = $type->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/companyAssets/types/index')->with('success','Asset type successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $type->del_status = 1;
                $type->update();
                $id = $type->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/companyAssets/types/index')->with('success','Asset type successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'description' => 'nullable',
            'attachment' => 'nullable'
        ]);
    }

}
