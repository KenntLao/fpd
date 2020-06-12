<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_projects;
use App\hris_clients;
use App\users;

class ProjectController extends Controller
{
    private $systemLog;
    private $module;

    public function __construct() {
        $this->systemLog = new SystemLogController;
        $this->module = 'Properties Setup - Project';
    }
    public function index()
    {
        $projects = hris_projects::paginate(10);
        return view('pages.admin.properties.projects.index', compact('projects'));
    }

    public function create(hris_projects $project)
    {
        $clients = hris_clients::all();
        return view('pages.admin.properties.projects.create', compact('project', 'clients'));
    }

    public function store(hris_projects $project, Request $request)
    {
        $action = 'add';
        if($this->validatedData()) {
            $project = hris_projects::create($this->validatedData());
            $id = $project->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/properties/projects/index')->with('success', 'Project successfully added!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_projects $project)
    {
        $clients = hris_clients::all();
        return view('pages.admin.properties.projects.edit', compact('project', 'clients'));
    }

    public function update(hris_projects $project, Request $request)
    {
        $id = $project->id;
        if($this->validatedData()) {
            $model = $project;
            //DO systemLog function FROM SystemLogController
            $this->systemLog->updateSystemLog($model,$this->module,$id);
            $project->update($this->validatedData());
            return redirect('/hris/pages/admin/properties/projects/index')->with('success', 'Project successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_projects $project)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $project->delete();
            $id = $project->id;
            $this->systemLog->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/properties/projects/index')->with('success', 'Project successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'client_id' => 'nullable',
            'status' => 'required',
            'details' => 'nullable'
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
