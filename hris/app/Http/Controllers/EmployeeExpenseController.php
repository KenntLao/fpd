<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_employee_expenses;
use App\hris_expenses_categories;
use App\hris_payment_methods;
use App\hris_currencies;

class EmployeeExpenseController extends Controller
{
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
        return view('pages.admin.benefits.employeeExpenses.create', compact('employeeExpense', 'currencies', 'expensesCategories', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $employeeExpense = new hris_employee_expenses();
        if($this->validatedData()) {
            if ( $request->hasFile('receipt') ) {
                $receipt = time() . '.' . $request->receipt->extension();
                $employeeExpense->receipt = $receipt;
                $request->receipt->move(public_path('assets/files/employee_expenses/receipt/'), $receipt);
            }
            if ( $request->hasFile('attachment_1') ) {
                $attachment_1 = time() . '.' . $request->attachment_1->extension();
                $employeeExpense->attachment_1 = $attachment_1;
                $request->attachment_1->move(public_path('assets/files/employee_expenses/attachment_1/'), $attachment_1);
            }
            if ( $request->hasFile('attachment_2') ) {
                $attachment_2 = time() . '.' . $request->attachment_2->extension();
                $employeeExpense->attachment_2 = $attachment_2;
                $request->attachment_2->move(public_path('assets/files/employee_expenses/attachment_2/'), $attachment_2);
            }
            $employeeExpense->employee = request('employee');
            $employeeExpense->expense_date = request('expense_date');
            $employeeExpense->payment_method = request('payment_method');
            $employeeExpense->ref_number = request('ref_number');
            $employeeExpense->payee = request('payee');
            $employeeExpense->expense_category = request('expense_category');
            $employeeExpense->notes = request('notes');
            $employeeExpense->currency = request('currency');
            $employeeExpense->amount = request('amount');
            $employeeExpense->status = 'Pending';
            $employeeExpense->save();
            return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee Expense successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_employee_expenses $employeeExpense)
    {
        $currencies = hris_currencies::all();
        $paymentMethods = hris_payment_methods::all();
        $expensesCategories = hris_expenses_categories::all();
        return view('pages.admin.benefits.employeeExpenses.edit', compact('employeeExpense', 'currencies', 'expensesCategories', 'paymentMethods'));
    }

    public function update(hris_employee_expenses $employeeExpense, Request $request)
    {
        if($this->validatedData()) {
            if ( $request->hasFile('receipt') ) {
                $path = public_path('assets/files/employee_expenses/receipt/');
                if ($employeeExpense->receipt != '' && $employeeExpense->receipt != NULL) {
                    $old_file = $path . $employeeExpense->receipt;
                    unlink($old_file);
                    $receipt = time() . '.' . $request->receipt->extension();
                    $employeeExpense->receipt = $receipt;
                    $request->receipt->move(public_path('assets/files/employee_expenses/receipt/'), $receipt);
                } else {
                    $receipt = time() . '.' . $request->receipt->extension();
                    $employeeExpense->receipt = $receipt;
                    $request->receipt->move(public_path('assets/files/employee_expenses/receipt/'), $receipt);
                }
            }
            if ( $request->hasFile('attachment_1') ) {
                $path = public_path('assets/files/employee_expenses/attachment_1/');
                if ($employeeExpense->attachment_1 != '' && $employeeExpense->attachment_1 != NULL) {
                    $old_file = $path . $employeeExpense->attachment_1;
                    unlink($old_file);
                    $attachment_1 = time() . '.' . $request->attachment_1->extension();
                    $employeeExpense->attachment_1 = $attachment_1;
                    $request->attachment_1->move(public_path('assets/files/employee_expenses/attachment_1/'), $attachment_1);
                } else {
                    $attachment_1 = time() . '.' . $request->attachment_1->extension();
                    $employeeExpense->attachment_1 = $attachment_1;
                    $request->attachment_1->move(public_path('assets/files/employee_expenses/attachment_1/'), $attachment_1);
                }
            }
            if ( $request->hasFile('attachment_2') ) {
                $path = public_path('assets/files/employee_expenses/attachment_2/');
                if ($employeeExpense->attachment_2 != '' && $employeeExpense->attachment_2 != NULL) {
                    $old_file = $path . $employeeExpense->attachment_2;
                    unlink($old_file);
                    $attachment_2 = time() . '.' . $request->attachment_2->extension();
                    $employeeExpense->attachment_2 = $attachment_2;
                    $request->attachment_2->move(public_path('assets/files/employee_expenses/attachment_2/'), $attachment_2);
                } else {
                    $attachment_2 = time() . '.' . $request->attachment_2->extension();
                    $employeeExpense->attachment_2 = $attachment_2;
                    $request->attachment_2->move(public_path('assets/files/employee_expenses/attachment_2/'), $attachment_2);
                }
            }
            $employeeExpense->employee = request('employee');
            $employeeExpense->expense_date = request('expense_date');
            $employeeExpense->payment_method = request('payment_method');
            $employeeExpense->ref_number = request('ref_number');
            $employeeExpense->payee = request('payee');
            $employeeExpense->expense_category = request('expense_category');
            $employeeExpense->notes = request('notes');
            $employeeExpense->currency = request('currency');
            $employeeExpense->amount = request('amount');
            $employeeExpense->status = 'Pending';
            $employeeExpense->update();
            return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee Expense successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }
    public function updateStatus(hris_employee_expenses $employeeExpense, Request $request)
    {
        $employeeExpense->status = request('status');
        $employeeExpense->update();
        return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee Expense status successfully updated!');
    }

    public function destroy(hris_employee_expenses $employeeExpense)
    {
        $employeeExpense->delete();
        $path1 = public_path('assets/files/employee_expenses/receipt/');
        $path2 = public_path('assets/files/employee_expenses/attachment_1/');
        $path3 = public_path('assets/files/employee_expenses/attachment_2/');
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
        return redirect('/hris/pages/admin/benefits/employeeExpenses/index')->with('success', 'Employee Expense successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'employee' => 'required',
            'expense_date' => 'required',
            'payment_method' => 'required',
            'payee' => 'required',
            'expense_category' => 'required',
            'notes' => 'required',
            'currency' => 'required',
            'amount' => 'required'
        ]);
    }

}
