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
        $types = hris_company_asset_types::paginate(10);
        return view('pages.admin.companyAssets.types.index', compact('types'));
    }

    public function create(hris_company_asset_types $type)
    {
        return view('pages.admin.companyAssets.types.create', compact('type'));
    }

    public function store(hris_company_asset_types $type, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            if( $request->hasFile('attachment') ) {
                $attachment = time() . '.' . $request->attachment->extension();
                $type->attachment = $attachment;
                $request->attachment->move(public_path('assets/files/companyAssets/types/'), $attachment);
            }
            $type->name = request('name');
            $type->description = request('description');
            $type->save();
            $id = $type->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $type;
            if( $request->hasFile('attachment') ) {
            $path = public_path('/assets/files/companyAssets/types/');
                if ($type->attachment != '' && $type->attachment != NULL) {
                    $old_file_1 = $path . $type->attachment;
                    unlink($old_file_1);
                    $attachment = time() . '.' . $request->attachment->extension();
                    $type->attachment = $attachment;
                    $request->attachment->move(public_path('/assets/files/companyAssets/types/'), $attachment);
                } else {
                    $attachment = time() . '.' . $request->attachment->extension();
                    $type->attachment = $attachment;
                    $request->attachment->move(public_path('/assets/files/companyAssets/types/'), $attachment);
                }
            }
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $type->name = request('name');
            $type->description = request('description');
            $type->update();
            return redirect('/hris/pages/admin/companyAssets/types/index')->with('success', 'Asset type successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_company_asset_types $type)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $type->delete();
            $path = public_path('assets/files/companyAssets/types/');
            if ($type->attachment != '' && $type->attachment != NULL) {
                $old_file = $path . $type->attachment;
                unlink($old_file);
            }
            $id = $type->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/companyAssets/types/index')->with('success','Asset type successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
