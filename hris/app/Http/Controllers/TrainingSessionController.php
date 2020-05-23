<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_training_sessions;
use App\hris_courses;

class TrainingSessionController extends Controller
{
    public function index()
    {

        $trainingSessions = hris_training_sessions::paginate(10);
        $id = hris_training_sessions::all()->get('id');
        $course = hris_courses::find($id);
        return view('pages.admin.training.trainingSessions.index', compact('trainingSessions'));
    }

    public function create(hris_training_sessions $trainingSession)
    {
        $courses = hris_courses::all();
        return view('pages.admin.training.trainingSessions.create', compact('trainingSession', 'courses'));
    }

    public function store(Request $request)
    {
        $trainingSession = new hris_training_sessions();
        if($request->hasFile('attachment')) {
            if($this->validatedData()) {
                $file = time() . '.' . $request->attachment->extension();
                $path = public_path('assets/files/training_session');
                $trainingSession->name = request('name');
                $trainingSession->course_id = request('course_id');
                $trainingSession->details = request('details');
                $trainingSession->scheduled_time = request('scheduled_time');
                $trainingSession->assignment_due_date = request('assignment_due_date');
                $trainingSession->delivery_method = request('delivery_method');
                $trainingSession->delivery_location = request('delivery_location');
                $trainingSession->attendance_type = request('attendance_type');
                $trainingSession->attachment = $file;
                $trainingSession->training_cert_required = request('training_cert_required');
                $request->attachment->move($path, $file);
                $trainingSession->save();
                return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training Session successfully added!');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_training_sessions $trainingSession)
    {
        $courses = hris_courses::all();
        return view('pages.admin.training.trainingSessions.edit', compact('trainingSession', 'courses'));
    }

    public function update(hris_training_sessions $trainingSession, Request $request)
    {
        if($request->hasFile('attachment')) {
            if($this->validatedData()) {
                $file = time() . '.' . $request->attachment->extension();
                $path = public_path('assets/files/training_session/');
                if ($trainingSession->attachment != '' && $trainingSession->attachment != NULL) {
                    $old_file = $path . $trainingSession->attachment;
                    unlink($old_file);
                }
                $trainingSession->name = request('name');
                $trainingSession->course_id = request('course_id');
                $trainingSession->details = request('details');
                $trainingSession->scheduled_time = request('scheduled_time');
                $trainingSession->assignment_due_date = request('assignment_due_date');
                $trainingSession->delivery_method = request('delivery_method');
                $trainingSession->delivery_location = request('delivery_location');
                $trainingSession->attendance_type = request('attendance_type');
                $trainingSession->attachment = $file;
                $trainingSession->training_cert_required = request('training_cert_required');
                $trainingSession->attachment->move(public_path('assets/files/training_session/'), $file);
                $trainingSession->update();
                return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training Session successfully updated!');
            } else {
                return back()->withErrors($this->validatedData());
            }
        } else {
            $trainingSession->name = request('name');
            $trainingSession->course_id = request('course_id');
            $trainingSession->details = request('details');
            $trainingSession->scheduled_time = request('scheduled_time');
            $trainingSession->assignment_due_date = request('assignment_due_date');
            $trainingSession->delivery_method = request('delivery_method');
            $trainingSession->delivery_location = request('delivery_location');
            $trainingSession->attendance_type = request('attendance_type');
            $trainingSession->training_cert_required = request('training_cert_required');
            $trainingSession->update();
            return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training Session successfully updated!');
        }
    }

    public function destroy(hris_training_sessions $trainingSession)
    {
        $trainingSession->delete();
        $path = public_path('assets/files/training_session/');
        if ($trainingSession->attachment != '' && $trainingSession->attachment != NULL) {
            $old_file = $path . $trainingSession->attachment;
            unlink($old_file);
        }
        return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training Session successfully deleted!');

    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'course_id' => 'required',
            'scheduled_time' => 'required',
            'delivery_method' => 'required',
            'attendance_type' => 'required',
            'training_cert_required' => 'required'
        ]);
    }

}
