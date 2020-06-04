<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_expenses_categories;
use App\users;

class ExpensesCategoryController extends Controller
{
    public function index()
    {
        $expensesCategories = hris_expenses_categories::paginate(10);
        return view('pages.admin.benefits.expensesCategories.index', compact('expensesCategories'));
    }

    public function create(hris_expenses_categories $expensesCategory)
    {
        return view('pages.admin.benefits.expensesCategories.create', compact('expensesCategory'));
    }

    public function store(Request $request)
    {
        $expensesCategory = new hris_expenses_categories();
        if($this->validatedData()) {
            $expensesCategory->name = request('name');
            $expensesCategory->save();
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses Category successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_expenses_categories $expensesCategory)
    {
        return view('pages.admin.benefits.expensesCategories.edit', compact('expensesCategory'));
    }

    public function update(hris_expenses_categories $expensesCategory, Request $request)
    {
        if($this->validatedData()) {
            $expensesCategory->name = request('name');
            $expensesCategory->update();
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses Category successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_expenses_categories $expensesCategory)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $expensesCategory->delete();
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses Category successfully deleted!');
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
