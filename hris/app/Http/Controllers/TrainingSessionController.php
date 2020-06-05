<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_training_sessions;
use App\hris_courses;
use App\users;

class TrainingSessionController extends Controller
{
    public function index()
    {

        $trainingSessions = hris_training_sessions::paginate(10);
        return view('pages.admin.training.trainingSessions.index', compact('trainingSessions'));
    }

    public function create(hris_training_sessions $trainingSession)
    {
        $courses = hris_courses::all();
        return view('pages.admin.training.trainingSessions.create', compact('trainingSession', 'courses'));
    }

    public function store(hris_training_sessions $trainingSession, Request $request)
    {
        if($this->validatedData()) {
            if($request->hasFile('attachment')) {
                $file = time() . '.' . $request->attachment->extension();
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
        $courses = hris_courses::all();
        return view('pages.admin.training.trainingSessions.edit', compact('trainingSession', 'courses'));
    }

    public function update(hris_training_sessions $trainingSession, Request $request)
    {
        if($this->validatedData()) {
            if ($request->hasFile('attachment')) {
                $path = public_path('assets/files/training_session/');
                if ($trainingSession->attachment != '' && $trainingSession->attachment != NULL) {
                    $old_file = $path . $trainingSession->attachment;
                    unlink($old_file);
                    $file = time() . '.' . $request->attachment->extension();
                    $trainingSession->attachment = $file;
                    $request->attachment->move($path, $file);
                } else {
                    $file = time() . '.' . $request->attachment->extension();
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
            $trainingSession->update();
            return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training session successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_training_sessions $trainingSession)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $trainingSession->delete();
            $path = public_path('assets/files/training_session/');
            if ($trainingSession->attachment != '' && $trainingSession->attachment != NULL) {
                $old_file = $path . $trainingSession->attachment;
                unlink($old_file);
            }
            return redirect('/hris/pages/admin/training/trainingSessions/index')->with('success', 'Training session successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
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
            'attachment' => 'nullable',
            'training_cert_required' => 'required'
        ]);
    }
    // decrypt string
    function decryptStr($str) {
        $key = '4507';
        $c = base64_decode($str);
        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
        $iv = substr($c,0,$ivlen);
        $hmac = substr($c,$ivlen,$sha2len=32);
        $ciphertext_raw = substr($c,$ivlen+$sha2len);
        $original_plaintext = openssl_decrypt($ciphertext_raw,$cipher,$key,$options=OPENSSL_RAW_DATA,$iv);
        $calcmac = hash_hmac('sha256',$ciphertext_raw,$key,$as_binary=true);
        if (hash_equals($hmac,$calcmac)) { return $original_plaintext; }
    }

}
