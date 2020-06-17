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
        $expensesCategories = hris_expenses_categories::paginate(10);
        return view('pages.admin.benefits.expensesCategories.index', compact('expensesCategories'));
    }

    public function create(hris_expenses_categories $expensesCategory)
    {
        return view('pages.admin.benefits.expensesCategories.create', compact('expensesCategory'));
    }

    public function store(hris_expenses_categories $expensesCategory, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $expensesCategory = hris_expenses_categories::create($this->validatedData());
            $id = $expensesCategory->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $expensesCategory;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $expensesCategory->update($this->validatedData());
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses category successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_expenses_categories $expensesCategory)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $expensesCategory->delete();
            $id = $expensesCategory->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses category successfully deleted!');
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

}
