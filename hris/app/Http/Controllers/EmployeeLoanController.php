<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_company_loan_types;
use App\hris_employee_loans;
use App\hris_currencies;
use App\users;
use App\hris_employee;

class EmployeeLoanController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Company Loans - Employee Loan';
    }
    public function index()
    {
        $employeeLoans = hris_employee_loans::where('del_status', 0)->paginate(10);
        return view('pages.admin.loans.employeeLoans.index', compact('employeeLoans'));
    }

    public function create(hris_employee_loans $employeeLoan)
    {
        $types = hris_company_loan_types::where('del_status', 0)->get();
        $currencies = hris_currencies::where('del_status', 0)->get();
        $employees = hris_employee::where('del_status', 0)->get();
        return view('pages.admin.loans.employeeLoans.create', compact('employeeLoan', 'types', 'currencies', 'employees'));
    }

    public function store(hris_employee_loans $employeeLoan, Request $request)
    {
        if($this->validatedData()) {
            $employeeLoan = hris_employee_loans::create($this->validatedData());
            $id = $employeeLoan->id;
            $this->function->addSystemLog($this->module,$id);
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
        $types = hris_company_loan_types::where('del_status', 0)->get();
        $currencies = hris_currencies::where('del_status', 0)->get();
        $employees = hris_employee::where('del_status', 0)->get();
        return view('pages.admin.loans.employeeLoans.edit', compact('employeeLoan', 'types', 'currencies', 'employees'));
    }

    public function update(hris_employee_loans $employeeLoan, Request $request)
    {
        $id = $employeeLoan->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee_loans';
            $employeeLoan->employee_id = request('employee_id');
            $employeeLoan->loan_type_id = request('loan_type_id');
            $employeeLoan->loan_start_date = request('loan_start_date');
            $employeeLoan->last_installment_date = request('last_installment_date');
            $employeeLoan->loan_period = request('loan_period');
            $employeeLoan->currency = request('currency');
            $employeeLoan->loan_amount = request('loan_amount');
            $employeeLoan->monthly_installment = request('monthly_installment');
            $employeeLoan->status = request('status');
            $employeeLoan->details = request('details');
            // GET CHANGES
            $changes = $employeeLoan->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employeeLoan->update();
            // GET CHANGES
            $changed = $employeeLoan->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employeeLoan->wasChanged() ) {
                return redirect('/hris/pages/admin/loans/employeeLoans/index')->with('success', 'Employee Loan successfully updated!');
            } else {
                return redirect('/hris/pages/admin/loans/employeeLoans/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_loans $employeeLoan)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $employeeLoan->del_status = 1;
                $employeeLoan->update();
                $id = $employeeLoan->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/loans/employeeLoans/index')->with('success', 'Employee Loan successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $employeeLoan->del_status = 1;
                $employeeLoan->update();
                $id = $employeeLoan->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/loans/employeeLoans/index')->with('success', 'Employee Loan successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'loan_type_id' => 'required',
            'loan_start_date' => 'required',
            'last_installment_date' => 'required',
            'loan_period' => 'required|integer',
            'currency' => 'required',
            'loan_amount' => 'required|integer',
            'monthly_installment' => 'required|integer',
            'status' => 'required',
            'details' => 'nullable'
        ]);
    }

}
