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
        if($this->validatedData()) {
            $project = hris_projects::create($this->validatedData());
            $id = $project->id;
            $this->function->addSystemLog($this->module,$id);
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
            $string = 'App\hris_projects';
            $project->name = request('name');
            $project->client_id = request('client_id');
            $project->status = request('status');
            $project->details = request('details');
            // GET CHANGES
            $changes = $project->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $project->update();
            // GET CHANGES
            $changed = $project->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $project->wasChanged() ) {
                return redirect('/hris/pages/admin/properties/projects/index')->with('success', 'Project successfully updated!');
            } else {
                return redirect('/hris/pages/admin/properties/projects/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_projects $project)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $project->delete();
                $id = $project->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/properties/projects/index')->with('success', 'Project successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $project->delete();
                $id = $project->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/properties/projects/index')->with('success', 'Project successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
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
