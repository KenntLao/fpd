<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_loan_types;
use App\users;

class CompanyLoanTypeController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Company Loans - Loan Type';
    }
    public function index()
    {
        $loanTypes = hris_company_loan_types::paginate(10);
        return view('pages.admin.loans.loanTypes.index', compact('loanTypes'));
    }

    public function create(hris_company_loan_types $loanType)
    {
        return view('pages.admin.loans.loanTypes.create', compact('loanType'));
    }

    public function store(hris_company_loan_types $loanType, Request $request)
    {
        if($this->validatedData()) {
            $loanType = hris_company_loan_types::create($this->validatedData());
            $id = $loanType->id;
            $this->function->addSystemLog($this->module,$id);
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
        $id = $loanType->id;
        if($this->validatedData()) {
            $string = 'App\hris_company_loan_types';
            $loanType->name = request('name');
            $loanType->details = request('details');
            // GET CHANGES
            $changes = $loanType->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $loanType->update();
            // GET CHANGES
            $changed = $loanType->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $loanType->wasChanged() ) {
                return redirect('/hris/pages/admin/loans/loanTypes/index')->with('success', 'Company Loan Type successfully updated!');
            } else {
                return redirect('/hris/pages/admin/loans/loanTypes/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_company_loan_types $loanType)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $loanType->delete();
            $id = $loanType->id;
            $this->function->deleteSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/loans/loanTypes/index')->with('success', 'Company Loan Type successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'details' => 'nullable'
        ]);
    }
}
