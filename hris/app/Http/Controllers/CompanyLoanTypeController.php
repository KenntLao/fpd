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
        $action = 'add';
        if($this->validatedData()) {
            $loanType = hris_company_loan_types::create($this->validatedData());
            $id = $loanType->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $loanType;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $loanType->update($this->validatedData());
            return redirect('/hris/pages/admin/loans/loanTypes/index')->with('success', 'Company Loan Type successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_company_loan_types $loanType)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $loanType->delete();
            $id = $loanType->id;
            $this->function->systemLog($this->module,$action,$id);
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
