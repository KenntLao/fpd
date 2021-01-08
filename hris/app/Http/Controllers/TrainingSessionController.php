<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_training_sessions;
use App\hris_courses;
use App\users;

class TrainingSessionController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Training Setup - Training Session';
    }
    public function index()
    {

        $trainingSessions = hris_training_sessions::where('del_status', 0)->paginate(10);
        return view('pages.admin.training.trainingSessions.index', compact('trainingSessions'));
    }

    public function create(hris_training_sessions $trainingSession)
    {
        $courses = hris_courses::all()->where('del_status', 0);
        return view('pages.admin.training.trainingSessions.create', compact('trainingSession', 'courses'));
    }

    public function store(hris_training_sessions $trainingSession, Request $request)
    {
        if($this->validatedData()) {
            if($request->hasFile('attachment')) {
                $file = time() . 'A.' . $request->attachment->getClientOriginalExtension();
                $path = public_path('assets/files/training_session');
                $trainingSession->attachment = $file;
                $request->attachment->move($path, $file);
            }
            $trainingSession->name = request('name');
            $trainingSession->course_id = request('course_id');
            $trainingSession->details = request('details');
            $trainingSession->scheduled_time = request('scheduled_time');
            $trainingSession->assignment_due_date = request('assignment_due_date');
            $trainingSession->delivery_method = request('delivery_method');
            $trainingSession->delivery_location = request('delivery_location');
            $trainingSession->attendance_type = request('attendance_type');
            $trainingSession->training_cert_required = request('training_cert_required');
            $trainingSession->save();
            $id = $trainingSession->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training session successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_training_sessions $trainingSession)
    {
        $courses = hris_courses::all()->where('del_status', 0);
        return view('pages.admin.training.trainingSessions.edit', compact('trainingSession', 'courses'));
    }

    public function update(hris_training_sessions $trainingSession, Request $request)
    {
        $id = $trainingSession->id;
        if($this->validatedData()) {
            $string = 'App\hris_training_sessions';
            if ($request->hasFile('attachment')) {
                $path = public_path('assets/files/training_session/');
                if ($trainingSession->attachment != '' && $trainingSession->attachment != NULL) {
                    $old_file = $path . $trainingSession->attachment;
                    unlink($old_file);
                    $file = time() . 'A.' . $request->attachment->getClientOriginalExtension();
                    $trainingSession->attachment = $file;
                    $request->attachment->move($path, $file);
                } else {
                    $file = time() . 'A.' . $request->attachment->getClientOriginalExtension();
                    $trainingSession->attachment = $file;
                    $request->attachment->move($path, $file);
                }
            }            
            $trainingSession->name = request('name');
            $trainingSession->course_id = request('course_id');
            $trainingSession->details = request('details');
            $trainingSession->scheduled_time = request('scheduled_time');
            $trainingSession->assignment_due_date = request('assignment_due_date');
            $trainingSession->delivery_method = request('delivery_method');
            $trainingSession->delivery_location = request('delivery_location');
            $trainingSession->attendance_type = request('attendance_type');
            $trainingSession->training_cert_required = request('training_cert_required');
            // GET CHANGES
            $changes = $trainingSession->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $trainingSession->update();
            // GET CHANGES
            $changed = $trainingSession->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $trainingSession->wasChanged() ) {
                return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training session successfully updated!');
            } else {
                return redirect('/hris/pages/admin/training/trainingSessions/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_training_sessions $trainingSession)
    {
        $id = $_SESSION['sys_id'];
        $path = public_path('assets/files/training_session/');
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $trainingSession->del_status = 1;
                $trainingSession->update();
                $id = $trainingSession->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training session successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $trainingSession->del_status = 1;
                $trainingSession->update();
                $id = $trainingSession->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training session successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }   

    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'course_id' => 'required',
            'details' => 'nullable',
            'scheduled_time' => 'required',
            'delivery_method' => 'required',
            'delivery_location' => 'nullable',
            'attendance_type' => 'required',
            'attachment' => 'nullable|file|mimes:docx,pdf,xls,xlsx',
            'training_cert_required' => 'required'
        ]);
    }

}
