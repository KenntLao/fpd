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
        $action = 'add';
        if($this->validatedData()) {
            $course = hris_courses::create($this->validatedData());
            $id = $course->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $course;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $course->update($this->validatedData());
            return redirect('/hris/pages/admin/training/courses/index')->with('success', 'Course successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_courses $course)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $course->delete();
            $id = $course->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/training/courses/index')->with('success', 'Course successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
            'cost' => 'required',
            'status' => 'required',
        ]);
    }

}
