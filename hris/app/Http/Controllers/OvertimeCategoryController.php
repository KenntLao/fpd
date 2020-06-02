<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_overtime_categories;

class OvertimeCategoryController extends Controller
{
    public function index()
    {
        $overtimeCategories = hris_overtime_categories::paginate(10);
        return view('pages.admin.overtime.overtimeCategories.index', compact('overtimeCategories'));
    }

    public function create(hris_overtime_categories $overtimeCategory)
    {
        return view('pages.admin.overtime.overtimeCategories.create', compact('overtimeCategory'));
    }

    public function store(Request $request)
    {
        $overtimeCategory = new hris_overtime_categories();
        if($this->validatedData()) {
            $overtimeCategory->name = request('name');
            $overtimeCategory->save();
            return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime Category successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_overtime_categories $overtimeCategory)
    {
        return view('pages.admin.overtime.overtimeCategories.edit', compact('overtimeCategory'));
    }

    public function update(hris_overtime_categories $overtimeCategory, Request $request)
    {
        if($this->validatedData()) {
            $overtimeCategory->name = request('name');
            $overtimeCategory->update();
            return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime Category successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_overtime_categories $overtimeCategory)
    {
        $overtimeCategory->delete();
        return redirect('/hris/pages/admin/overtime/overtimeCategories/index')->with('success', 'Overtime Category successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }

}
