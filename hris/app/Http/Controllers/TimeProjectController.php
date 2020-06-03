<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_projects;
use App\hris_time_projects;
use App\users;

class TimeProjectController extends Controller
{

    public function index()
    {
        $timeProjects = hris_time_projects::paginate(10);
        return view('pages.time.timeProjects.index', compact('timeProjects'));
    }

    public function create(hris_time_projects $timeProject)
    {
        $projects = hris_time_projects::all();
        return view('pages.time.timeProjects.create', compact('timeProject', 'projects'));
    }

    public function store(Request $request)
    {
        $timeProject = new hris_time_projects();
        if($this->validatedData()) {
            $timeProject->project = request('project');
            $timeProject->details = request('details');
            $timeProject->save();
            return redirect('/hris/pages/time/timeProjects/index')->with('success', 'Project successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_time_projects $timeProject)
    {
        $projects = hris_projects::all();
        return view('pages.time.timeProjects.edit', compact('timeProject', 'projects'));
    }

    public function update(hris_time_projects $timeProject, Request $request)
    {
        if($this->validatedData()) {
            $timeProject->project = request('project');
            $timeProject->details = request('details');
            $timeProject->update();
            return redirect('/hris/pages/time/timeProjects/index')->with('success', 'Project successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_time_projects $timeProject)
    {
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $timeProject->delete();
            return redirect('/hris/pages/time/timeProjects/index')->with('success', 'Project successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'project' => 'required'
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
