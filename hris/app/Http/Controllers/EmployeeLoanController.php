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
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Company Loans - Employee Loan';
    }
    public function index()
    {
        $employeeLoans = hris_employee_loans::paginate(10);
        return view('pages.admin.loans.employeeLoans.index', compact('employeeLoans'));
    }

    public function create(hris_employee_loans $employeeLoan)
    {
        $types = hris_company_loan_types::all();
        $currencies = hris_currencies::all();
        $employees = hris_employee::all();
        return view('pages.admin.loans.employeeLoans.create', compact('employeeLoan', 'types', 'currencies', 'employees'));
    }

    public function store(hris_employee_loans $employeeLoan, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $employeeLoan = hris_employee_loans::create($this->validatedData());
            $id = $employeeLoan->id;
            $this->systemLog->systemLog($this->module,$action,$id);
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
        $employees = hris_employee::all();
        return view('pages.admin.loans.employeeLoans.edit', compact('employeeLoan', 'types', 'currencies', 'employees'));
    }

    public function update(hris_employee_loans $employeeLoan, Request $request)
    {
        $id = $employeeLoan->id;
        if($this->validatedData()) {
            $model = $employeeLoan;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $employeeLoan->update($this->validatedData());
            return redirect('/hris/pages/admin/loans/employeeLoans/index')->with('success', 'Employee Loan successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_employee_loans $employeeLoan)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $employeeLoan->delete();
            $id = $employeeLoan->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/loans/employeeLoans/index')->with('success', 'Employee Loan successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'type_id' => 'required',
            'loan_start_date' => 'required',
            'last_installment_date' => 'required',
            'loan_period' => 'required',
            'currency' => 'required',
            'loan_amount' => 'required',
            'monthly_installment' => 'required',
            'status' => 'required',
            'details' => 'nullable'
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
