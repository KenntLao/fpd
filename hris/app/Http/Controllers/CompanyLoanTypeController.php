<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_loan_types;
use App\users;

class CompanyLoanTypeController extends Controller
{
    public function index()
    {
        $loanTypes = hris_company_loan_types::paginate(10);
        return view('pages.admin.loans.loanTypes.index', compact('loanTypes'));
    }

    public function create(hris_company_loan_types $loanType)
    {
        return view('pages.admin.loans.loanTypes.create', compact('loanType'));
    }

    public function store(Request $request)
    {
        $loanType = new hris_company_loan_types();
        if($this->validatedData()) {
            $loanType->name = request('name');
            $loanType->details = request('details');
            $loanType->save();
            return redirect('/hris/pages/admin/loans/loanTypes/index')->with('success', 'Company Loan Type successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_company_loan_types $loanType)
    {
        return view('pages.admin.loans.loanTypes.edit', compact('loanType'));
    }

    public function update(hris_company_loan_types $loanType, Request $request)
    {
        if($this->validatedData()) {
            $loanType->name = request('name');
            $loanType->details = request('details');
            $loanType->update();
            return redirect('/hris/pages/admin/loans/loanTypes/index')->with('success', 'Company Loan Type successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_company_loan_types $loanType)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $loanType->delete();
            return redirect('/hris/pages/admin/loans/loanTypes/index')->with('success', 'Company Loan Type successfully deleted!');
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
