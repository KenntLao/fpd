<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_courses;
use App\users;

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
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $course->delete();
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
            'payment_type' => 'required',
            'currency' => 'required',
            'cost' => 'required',
            'status' => 'required',
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
