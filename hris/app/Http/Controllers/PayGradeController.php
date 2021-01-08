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
        $payGrades = hris_pay_grades::where('del_status', 0)->paginate(10);
        return view('pages.admin.jobDetails.payGrades.index', compact('payGrades'));
    }

    public function create(hris_pay_grades $payGrade)
    {
        return view('pages.admin.jobDetails.payGrades.create', compact('payGrade'));
    }

    public function store(hris_pay_grades $payGrade, Request $request)
    {
        if ($this->validatedData()) {
            $count = hris_pay_grades::where('name', request('name'))->where('del_status', 0)->get()->count();
            if ( $count == 1 ) {
                return redirect('hris/pages/admin/jobDetails/payGrades/index')->withErrors(['Pay grade already exists.']);
            } else {
                $payGrade = hris_pay_grades::create($this->validatedData());
                $payGrade->save();
                return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay grade successfully updated!');
            }
            
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
            $check = hris_pay_grades::where('name', request('name'))->where('del_status', 0)->first();
            $count = hris_pay_grades::where('name', request('name'))->where('del_status', 0)->get()->count();
            if ( $count == 1 ) {
                if ( $check->id == $id ) {
                    $string = 'App\hris_pay_grades';
                    $payGrade->name = request('name');
                    $payGrade->currency = request('currency');
                    $payGrade->min_salary = request('min_salary');
                    $payGrade->max_salary = request('max_salary');
                    // GET CHANGES
                    $changes = $payGrade->getDirty();
                    // GET ORIGINAL DATA
                    $this->function->getOldData($this->module,$string,$changes,$id);
                    $payGrade->update();
                    // GET CHANGES
                    $changed = $payGrade->getChanges();
                    // USE UPDATESYSTEMLOG FUNCTION
                    $this->function->updateSystemLog($this->module,$changed,$string,$id);
                    if ( $payGrade->wasChanged() ) {
                        return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay grade successfully updated!');
                    } else {
                        return redirect('/hris/pages/admin/jobDetails/payGrades/index');
                    }
                } else {
                    return back()->withErrors(['Pay grade already exists.']);
                }
            } else {
                $string = 'App\hris_pay_grades';
                $payGrade->name = request('name');
                $payGrade->currency = request('currency');
                $payGrade->min_salary = request('min_salary');
                $payGrade->max_salary = request('max_salary');
                // GET CHANGES
                $changes = $payGrade->getDirty();
                // GET ORIGINAL DATA
                $this->function->getOldData($this->module,$string,$changes,$id);
                $payGrade->update();
                // GET CHANGES
                $changed = $payGrade->getChanges();
                // USE UPDATESYSTEMLOG FUNCTION
                $this->function->updateSystemLog($this->module,$changed,$string,$id);
                if ( $payGrade->wasChanged() ) {
                    return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay grade successfully updated!');
                } else {
                    return redirect('/hris/pages/admin/jobDetails/payGrades/index');
                }
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_pay_grades $payGrade)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $payGrade->del_status = 1;
                $payGrade->update();
                $id = $payGrade->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay grade successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $payGrade->del_status = 1;
                $payGrade->update();
                $id = $payGrade->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/jobDetails/payGrades/index')->with('success', 'Pay grade successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData() {

        return request()->validate([
            'name' => 'required',
            'currency' => 'required',
            'min_salary' => 'required|integer',
            'max_salary' => 'required|integer'
        ]);

    }

}
