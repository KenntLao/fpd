<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employee_expenses;
use App\hris_expenses_categories;
use App\hris_payment_methods;
use App\hris_currencies;
use App\users;
use App\hris_employee;

class EmployeeExpenseController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Benefits Administration - Employee Expense';
    }
    public function index()
    {
        $employeeExpenses = hris_employee_expenses::paginate(10);
        return view('pages.admin.benefits.employeeExpenses.index', compact('employeeExpenses'));
    }

    public function create(hris_employee_expenses $employeeExpense)
    {
        $currencies = hris_currencies::all();
        $paymentMethods = hris_payment_methods::all();
        $expensesCategories = hris_expenses_categories::all();
        $employees = hris_employee::all();
        return view('pages.admin.benefits.employeeExpenses.create', compact('employeeExpense', 'currencies', 'expensesCategories', 'paymentMethods', 'employees'));
    }

    public function store(hris_employee_expenses $employeeExpense,Request $request)
    {
        if($this->validatedData()) {
            if ( $request->hasFile('receipt') ) {
                $receipt = time() . 'RCPT.' . $request->receipt->extension();
                $employeeExpense->receipt = $receipt;
                $request->receipt->move(public_path('assets/files/employee_expenses/receipt/'), $receipt);
            }
            if ( $request->hasFile('attachment_1') ) {
                $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                $employeeExpense->attachment_1 = $attachment_1;
                $request->attachment_1->move(public_path('assets/files/employee_expenses/attachment_1/'), $attachment_1);
            }
            if ( $request->hasFile('attachment_2') ) {
                $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                $employeeExpense->attachment_2 = $attachment_2;
                $request->attachment_2->move(public_path('assets/files/employee_expenses/attachment_2/'), $attachment_2);
            }
            $employeeExpense->employee_id = request('employee_id');
            $employeeExpense->expense_date = request('expense_date');
            $employeeExpense->payment_method_id = request('payment_method_id');
            $employeeExpense->ref_number = request('ref_number');
            $employeeExpense->payee = request('payee');
            $employeeExpense->expense_category_id = request('expense_category_id');
            $employeeExpense->notes = request('notes');
            $employeeExpense->currency = request('currency');
            $employeeExpense->amount = request('amount');
            $employeeExpense->status = '0';
            $employeeExpense->save();
            $id = $employeeExpense->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee Expense successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show(hris_employee_expenses $employeeExpense)
    {
        return view('pages.admin.benefits.employeeExpenses.show', compact('employeeExpense'));
    }

    public function edit(hris_employee_expenses $employeeExpense)
    {
        $currencies = hris_currencies::all();
        $paymentMethods = hris_payment_methods::all();
        $expensesCategories = hris_expenses_categories::all();
        $employees = hris_employee::all();
        return view('pages.admin.benefits.employeeExpenses.edit', compact('employeeExpense', 'currencies', 'expensesCategories', 'paymentMethods', 'employees'));
    }

    public function update(hris_employee_expenses $employeeExpense, Request $request)
    {
        $id = $employeeExpense->id;
        if($this->validatedData()) {
            $string = 'App\hris_employee_expenses';
            if ( $request->hasFile('receipt') ) {
                $path = public_path('assets/files/employee_expenses/receipt/');
                if ($employeeExpense->receipt != '' && $employeeExpense->receipt != NULL) {
                    $old_file = $path . $employeeExpense->receipt;
                    unlink($old_file);
                    $receipt = time() . 'RCPT.' . $request->receipt->extension();
                    $employeeExpense->receipt = $receipt;
                    $request->receipt->move($path, $receipt);
                } else {
                    $receipt = time() . 'RCPT.' . $request->receipt->extension();
                    $employeeExpense->receipt = $receipt;
                    $request->receipt->move(public_path('assets/files/employee_expenses/receipt/'), $receipt);
                }
            }
            if ( $request->hasFile('attachment_1') ) {
                $path = public_path('assets/files/employee_expenses/attachment_1/');
                if ($employeeExpense->attachment_1 != '' && $employeeExpense->attachment_1 != NULL) {
                    $old_file = $path . $employeeExpense->attachment_1;
                    unlink($old_file);
                    $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                    $employeeExpense->attachment_1 = $attachment_1;
                    $request->attachment_1->move($path, $attachment_1);
                } else {
                    $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                    $employeeExpense->attachment_1 = $attachment_1;
                    $request->attachment_1->move($path, $attachment_1);
                }
            }
            if ( $request->hasFile('attachment_2') ) {
                $path = public_path('assets/files/employee_expenses/attachment_2/');
                if ($employeeExpense->attachment_2 != '' && $employeeExpense->attachment_2 != NULL) {
                    $old_file = $path . $employeeExpense->attachment_2;
                    unlink($old_file);
                    $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                    $employeeExpense->attachment_2 = $attachment_2;
                    $request->attachment_2->move($path, $attachment_2);
                } else {
                    $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                    $employeeExpense->attachment_2 = $attachment_2;
                    $request->attachment_2->move($path, $attachment_2);
                }
            }
            $employeeExpense->employee_id = request('employee_id');
            $employeeExpense->expense_date = request('expense_date');
            $employeeExpense->payment_method_id = request('payment_method_id');
            $employeeExpense->ref_number = request('ref_number');
            $employeeExpense->payee = request('payee');
            $employeeExpense->expense_category_id = request('expense_category_id');
            $employeeExpense->notes = request('notes');
            $employeeExpense->currency = request('currency');
            $employeeExpense->amount = request('amount');
            $employeeExpense->status = '0';
            // GET CHANGES
            $changes = $employeeExpense->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $employeeExpense->update();
            // GET CHANGES
            $changed = $employeeExpense->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $employeeExpense->wasChanged() ) {
                return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee Expense successfully updated!');
            } else {
                return redirect('/hris/pages/admin/benefits/employeeExpenses/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function updateStatus($status, hris_employee_expenses $employeeExpense)
    {
        $id = $employeeExpense->id;
        $string = 'App\hris_employee_expenses';
        $this->function->statusSystemLog($this->module,$string,$id);
        if ( $status == '1' OR $status == '2' ) {
            if ( $status == '1' ) {
                $msg = 'accepted';
            }
            if ( $status == '2' ) {
                $msg = 'rejected';
            }
            $employeeExpense->status = $status;
        } else {
            return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->withErrors(['Invalid status!']);
        }
        $employeeExpense->update();
        return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee expense '.$msg.'!');
    }

    public function destroy(hris_employee_expenses $employeeExpense)
    {
        $id = $_SESSION['sys_id'];
        $path1 = public_path('assets/files/employee_expenses/receipt/');
        $path2 = public_path('assets/files/employee_expenses/attachment_1/');
        $path3 = public_path('assets/files/employee_expenses/attachment_2/');
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $employeeExpense->delete();
                if ($employeeExpense->receipt != '' && $employeeExpense->receipt != NULL) {
                    $old_file = $path1 . $employeeExpense->receipt;
                    unlink($old_file);
                }
                if ($employeeExpense->attachment_1 != '' && $employeeExpense->attachment_1 != NULL) {
                    $old_file = $path2 . $employeeExpense->attachment_1;
                    unlink($old_file);
                }
                if ($employeeExpense->attachment_2 != '' && $employeeExpense->attachment_2 != NULL) {
                    $old_file = $path3 . $employeeExpense->attachment_2;
                    unlink($old_file);
                }
                $id = $employeeExpense->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee Expense successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $employeeExpense->delete();
                if ($employeeExpense->receipt != '' && $employeeExpense->receipt != NULL) {
                    $old_file = $path1 . $employeeExpense->receipt;
                    unlink($old_file);
                }
                if ($employeeExpense->attachment_1 != '' && $employeeExpense->attachment_1 != NULL) {
                    $old_file = $path2 . $employeeExpense->attachment_1;
                    unlink($old_file);
                }
                if ($employeeExpense->attachment_2 != '' && $employeeExpense->attachment_2 != NULL) {
                    $old_file = $path3 . $employeeExpense->attachment_2;
                    unlink($old_file);
                }
                $id = $employeeExpense->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee Expense successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee_id' => 'required',
            'expense_date' => 'required',
            'payment_method_id' => 'required',
            'ref_number' => 'nullable',
            'payee' => 'required',
            'expense_category_id' => 'required',
            'notes' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'receipt' => 'nullable',
            'attachment_1' => 'nullable',
            'attachment_2' => 'nullable',
            'status' => 'nullable'
        ]);
    }

}
