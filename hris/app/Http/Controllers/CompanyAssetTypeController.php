<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_asset_types;
use App\users;

class CompanyAssetTypeController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
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
            $this->systemLog->systemLog($this->module,$action,$id);
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
            $this->systemLog->updateSystemLog($model,$this->module,$id);
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
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $type->delete();
            $path = public_path('assets/files/companyAssets/types/');
            if ($type->attachment != '' && $type->attachment != NULL) {
                $old_file = $path . $type->attachment;
                unlink($old_file);
            }
            $id = $type->id;
            $this->systemLog->systemLog($this->module,$action,$id);
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
