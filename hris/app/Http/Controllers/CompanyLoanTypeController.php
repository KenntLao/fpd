<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_loan_types;

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
        $loanType->delete();
        return redirect('/hris/pages/admin/loans/loanTypes/index')->with('success', 'Company Loan Type successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }

}
