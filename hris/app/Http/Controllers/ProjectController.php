<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_projects;
use App\hris_clients;

class ProjectController extends Controller
{
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

    public function store(Request $request)
    {
        $project = new hris_projects();
        if($this->validatedData()) {
            $project->name = request('name');
            $project->client = request('client');
            $project->details = request('details');
            $project->status = request('status');
            $project->save();
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
        if($this->validatedData()) {
            $project->name = request('name');
            $project->client = request('client');
            $project->details = request('details');
            $project->status = request('status');
            $project->update();
            return redirect('/hris/pages/admin/properties/projects/index')->with('success', 'Project successfully updated!');
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function destroy(hris_projects $project)
    {
        $project->delete();
        return redirect('/hris/pages/admin/properties/projects/index')->with('success', 'Project successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required',
            'status' => 'required'
        ]);
    }

}
