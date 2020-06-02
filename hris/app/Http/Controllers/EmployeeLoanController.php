<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_loan_types;
use App\hris_employee_loans;
use App\hris_currencies;

class EmployeeLoanController extends Controller
{
    public function index()
    {
        $employeeLoans = hris_employee_loans::paginate(10);
        return view('pages.admin.loans.employeeLoans.index', compact('employeeLoans'));
    }

    public function create(hris_employee_loans $employeeLoan)
    {
        $types = hris_company_loan_types::all();
        $currencies = hris_currencies::all();
        return view('pages.admin.loans.employeeLoans.create', compact('employeeLoan', 'types', 'currencies'));
    }

    public function store(Request $request)
    {
        $employeeLoan = new hris_employee_loans();
        if($this->validatedData()) {
            $employeeLoan->employee = request('employee');
            $employeeLoan->type = request('type');
            $employeeLoan->loan_start_date = request('loan_start_date');
            $employeeLoan->last_installment_date = request('last_installment_date');
            $employeeLoan->loan_period = request('loan_period');
            $employeeLoan->currency = request('currency');
            $employeeLoan->loan_amount = request('loan_amount');
            $employeeLoan->monthly_installment = request('monthly_installment');
            $employeeLoan->status = request('status');
            $employeeLoan->details = request('details');
            $employeeLoan->save();
            return redirect('/hris/pages/admin/loans/employeeLoans/index')->with('success', 'Employee Loan successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_loans $employeeLoan)
    {
        $types = hris_company_loan_types::all();
        $currencies = hris_currencies::all();
        return view('pages.admin.loans.employeeLoans.edit', compact('employeeLoan', 'types', 'currencies'));
    }

    public function update(hris_employee_loans $employeeLoan, Request $request)
    {
        if($this->validatedData()) {
            $employeeLoan->employee = request('employee');
            $employeeLoan->type = request('type');
            $employeeLoan->loan_start_date = request('loan_start_date');
            $employeeLoan->last_installment_date = request('last_installment_date');
            $employeeLoan->loan_period = request('loan_period');
            $employeeLoan->currency = request('currency');
            $employeeLoan->loan_amount = request('loan_amount');
            $employeeLoan->monthly_installment = request('monthly_installment');
            $employeeLoan->status = request('status');
            $employeeLoan->details = request('details');
            $employeeLoan->update();
            return redirect('/hris/pages/admin/loans/employeeLoans/index')->with('success', 'Employee Loan successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_loans $employeeLoan)
    {
        $employeeLoan->delete();
        return redirect('/hris/pages/admin/loans/employeeLoans/index')->with('success', 'Employee Loan successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee' => 'required',
            'type' => 'required',
            'loan_start_date' => 'required',
            'last_installment_date' => 'required',
            'loan_period' => 'required',
            'currency' => 'required',
            'loan_amount' => 'required',
            'monthly_installment' => 'required',
            'status' => 'required'
        ]);
    }

}
