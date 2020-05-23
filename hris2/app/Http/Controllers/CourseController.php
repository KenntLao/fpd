<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_courses;

class CourseController extends Controller
{
    public function index()
    {
        $courses = hris_courses::paginate(10);
        return view('pages.admin.training.courses.index', compact('courses'));
    }

    public function create(hris_courses $course)
    {
        return view('pages.admin.training.courses.create', compact('course'));
    }

    public function store(Request $request)
    {
        $course = new hris_courses();
        if($this->validatedData()) {
            $course->code = request('code');
            $course->name = request('name');
            $course->coordinator = request('coordinator');
            $course->trainer = request('trainer');
            $course->trainer_details = request('trainer_details');
            $course->payment_type = request('payment_type');
            $course->currency = request('currency');
            $course->cost = request('cost');
            $course->status = request('status');
            $course->save();
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
        if($this->validatedData()) {
            $course->code = request('code');
            $course->name = request('name');
            $course->coordinator = request('coordinator');
            $course->trainer = request('trainer');
            $course->trainer_details = request('trainer_details');
            $course->payment_type = request('payment_type');
            $course->currency = request('currency');
            $course->cost = request('cost');
            $course->status = request('status');
            $course->update();
            return redirect('/hris/pages/admin/training/courses/index')->with('success', 'Course successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_courses $course)
    {
        $course->delete();
        return redirect('/hris/pages/admin/training/courses/index')->with('success', 'Course successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'code' => 'required',
            'name' => 'required',
            'coordinator' => 'required',
            'payment_type' => 'required',
            'currency' => 'required',
            'cost' => 'required',
            'status' => 'required',
        ]);
    }

}
