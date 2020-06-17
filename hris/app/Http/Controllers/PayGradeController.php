<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_pay_grades;
use App\users;

class PayGradeController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Job Details Setup - Pay Grade';
    }
    public function index()
    {
        $payGrades = hris_pay_grades::paginate(10);
        return view('pages.admin.jobDetails.payGrades.index', compact('payGrades'));
    }

    public function create(hris_pay_grades $payGrade)
    {
        return view('pages.admin.jobDetails.payGrades.create', compact('payGrade'));
    }

    public function store(hris_pay_grades $payGrade, Request $request)
    {
        $action = 'add';
        if ($this->validatedData()) {
            $payGrade = hris_pay_grades::create($this->validatedData());
            $id = $payGrade->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay grade successfully added!');
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
        $id = $payGrade->id;
        if($this->validatedData()) {
            $model = $payGrade;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $payGrade->update($this->validatedData());
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay grade successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_pay_grades $payGrade)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $payGrade->delete();
            $id = $payGrade->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay grade successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
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
