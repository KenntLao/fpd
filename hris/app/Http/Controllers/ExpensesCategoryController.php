<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_expenses_categories;
use App\users;

class ExpensesCategoryController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Benefits Administration - Expenses Category';
    }
    public function index()
    {
        $expensesCategories = hris_expenses_categories::where('del_status', 0)->paginate(10);
        return view('pages.admin.benefits.expensesCategories.index', compact('expensesCategories'));
    }

    public function create(hris_expenses_categories $expensesCategory)
    {
        return view('pages.admin.benefits.expensesCategories.create', compact('expensesCategory'));
    }

    public function store(hris_expenses_categories $expensesCategory, Request $request)
    {
        if($this->validatedData()) {
            $expensesCategory = hris_expenses_categories::create($this->validatedData());
            $id = $expensesCategory->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_expenses_categories';
            $expensesCategory->name = request('name');
            // GET CHANGES
            $changes = $expensesCategory->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $expensesCategory->update();
            // GET CHANGES
            $changed = $expensesCategory->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $expensesCategory->wasChanged() ) {
                return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses category successfully updated!');
            } else {
                return redirect('/hris/pages/admin/benefits/expensesCategories/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_expenses_categories $expensesCategory)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $expensesCategory->del_status = 1;
                $expensesCategory->update();
                $id = $expensesCategory->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses category successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $expensesCategory->del_status = 1;
                $expensesCategory->update();
                $id = $expensesCategory->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses category successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }

}
