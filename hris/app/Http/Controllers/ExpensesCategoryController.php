<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_expenses_categories;
use App\users;

class ExpensesCategoryController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Benefits Administration - Expenses Category';
    }
    public function index()
    {
        $expensesCategories = hris_expenses_categories::paginate(10);
        return view('pages.admin.benefits.expensesCategories.index', compact('expensesCategories'));
    }

    public function create(hris_expenses_categories $expensesCategory)
    {
        return view('pages.admin.benefits.expensesCategories.create', compact('expensesCategory'));
    }

    public function store(hris_expenses_categories $expensesCategory, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $expensesCategory = hris_expenses_categories::create($this->validatedData());
            $id = $expensesCategory->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses category successfully added!');
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
        $id = $expensesCategory->id;
        if($this->validatedData()) {
            $model = $expensesCategory;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $expensesCategory->update($this->validatedData());
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses category successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_expenses_categories $expensesCategory)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $expensesCategory->delete();
            $id = $expensesCategory->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses category successfully deleted!');
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
