<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_expenses_categories;

class ExpensesCategoryController extends Controller
{
    public function index()
    {
        $expensesCategories = hris_expenses_categories::paginate(10);
        return view('pages.admin.benefits.expensesCategories.index', compact('expensesCategories'));
    }

    public function create(hris_expenses_categories $expensesCategory)
    {
        return view('pages.admin.benefits.expensesCategories.create', compact('expensesCategory'));
    }

    public function store(Request $request)
    {
        $expensesCategory = new hris_expenses_categories();
        if($this->validatedData()) {
            $expensesCategory->name = request('name');
            $expensesCategory->save();
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses Category successfully added!');
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
        if($this->validatedData()) {
            $expensesCategory->name = request('name');
            $expensesCategory->update();
            return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses Category successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_expenses_categories $expensesCategory)
    {
        $expensesCategory->delete();
        return redirect('/hris/pages/admin/benefits/expensesCategories/index')->with('success', 'Expenses Category successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }

}
