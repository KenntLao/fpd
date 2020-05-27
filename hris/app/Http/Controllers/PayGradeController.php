<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_pay_grades;

class PayGradeController extends Controller
{
    public function index()
    {
        $payGrades = hris_pay_grades::paginate(10);
        return view('pages.admin.jobDetails.payGrades.index', compact('payGrades'));
    }

    public function create(hris_pay_grades $payGrade)
    {
        return view('pages.admin.jobDetails.payGrades.create', compact('payGrade'));
    }

    public function store(Request $request)
    {
        $payGrade = new hris_pay_grades();
        if ($this->validatedData()) {
            $payGrade->name = request('name');
            $payGrade->currency = request('currency');
            $payGrade->min_salary = request('min_salary');
            $payGrade->max_salary = request('max_salary');
            $payGrade->save();
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay Grade successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_pay_grades $payGrade)
    {
        return view('pages.admin.jobDetails.payGrades.edit', compact('payGrade'));
    }

    public function update(hris_pay_grades $payGrade ,Request $request)
    {
        if($this->validatedData()) {
            $payGrade->name = request('name');
            $payGrade->currency = request('currency');
            $payGrade->min_salary = request('min_salary');
            $payGrade->max_salary = request('max_salary');
            $payGrade->update();
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay Grade successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_pay_grades $payGrade)
    {
        $payGrade->delete();
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay Grade successfully deleted!');
    }

    protected function validatedData() {

        return request()->validate([
            'name' => 'required',
            'currency' => 'required',
            'min_salary' => 'required',
            'max_salary' => 'required'
        ]);

    }

}
