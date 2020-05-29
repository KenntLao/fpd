<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_projects;
use App\hris_time_projects;

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
        $timeProject->delete();
        return redirect('/hris/pages/time/timeProjects/index')->with('success', 'Project successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'project' => 'required'
        ]);
    }

}
