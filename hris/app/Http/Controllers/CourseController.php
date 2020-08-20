<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_courses;
use App\users;

class CourseController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Training Setup - Course';
    }
    public function index()
    {
        $courses = hris_courses::paginate(10);
        return view('pages.admin.training.courses.index', compact('courses'));
    }

    public function create(hris_courses $course)
    {
        return view('pages.admin.training.courses.create', compact('course'));
    }

    public function store(hris_courses $course, Request $request)
    {
        if($this->validatedData()) {
            $course = hris_courses::create($this->validatedData());
            $id = $course->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/training/courses/index')->with('success', 'Course successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_courses $course)
    {
        return view('pages.admin.training.courses.edit', compact('course'));
    }

    public function update(hris_courses $course, Request $request)
    {
        $id = $course->id;
        if($this->validatedData()) {
            $string = 'App\hris_courses';
            $course->code = request('code');
            $course->name = request('name');
            $course->coordinator = request('coordinator');
            $course->trainer = request('trainer');
            $course->trainer_details = request('trainer_details');
            $course->payment_type = request('payment_type');
            $course->currency = request('currency');
            $course->cost = request('cost');
            $course->status = request('status');
            // GET CHANGES
            $changes = $course->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $course->update();
            // GET CHANGES
            $changed = $course->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $course->wasChanged() ) {
                return redirect('/hris/pages/admin/training/courses/index')->with('success', 'Course successfully updated!');
            } else {
                return redirect('/hris/pages/admin/training/courses/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_courses $course)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $course->delete();
                $id = $course->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/courses/index')->with('success', 'Course successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $course->delete();
                $id = $course->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/courses/index')->with('success', 'Course successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'code' => 'required',
            'name' => 'required',
            'coordinator' => 'required',
            'trainer' => 'nullable',
            'trainer_details' => 'nullable',
            'payment_type' => 'required',
            'currency' => 'required',
            'cost' => 'required|integer',
            'status' => 'required',
        ]);
    }

}
