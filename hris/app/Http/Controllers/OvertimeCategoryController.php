<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_overtime_categories;
use App\users;

class OvertimeCategoryController extends Controller
{
    public function index()
    {
        $overtimeCategories = hris_overtime_categories::paginate(10);
        return view('pages.admin.overtime.overtimeCategories.index', compact('overtimeCategories'));
    }

    public function create(hris_overtime_categories $overtimeCategory)
    {
        return view('pages.admin.overtime.overtimeCategories.create', compact('overtimeCategory'));
    }

    public function store(Request $request)
    {
        $overtimeCategory = new hris_overtime_categories();
        if($this->validatedData()) {
            $overtimeCategory->name = request('name');
            $overtimeCategory->save();
            return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime Category successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_overtime_categories $overtimeCategory)
    {
        return view('pages.admin.overtime.overtimeCategories.edit', compact('overtimeCategory'));
    }

    public function update(hris_overtime_categories $overtimeCategory, Request $request)
    {
        if($this->validatedData()) {
            $overtimeCategory->name = request('name');
            $overtimeCategory->update();
            return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime Category successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_overtime_categories $overtimeCategory)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $overtimeCategory->delete();
            return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime Category successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
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
