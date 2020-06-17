<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_projects;
use App\hris_clients;
use App\users;

class ProjectController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
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
            $this->function->systemLog($this->module,$action,$id);
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
            $this->function->updateSystemLog($model,$this->module,$id);
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
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $project->delete();
            $id = $project->id;
            $this->function->systemLog($this->module,$action,$id);
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

}
