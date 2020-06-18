<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_overtime;

class OvertimeController extends Controller
{
    //
    public function index(hris_overtime $overtimes)
    {
        $overtimes = hris_overtime::paginate(10);
        return view('pages.time.overtime.index', compact('overtimes'));
    }
    public function create(hris_overtime $overtime)
    {
        return view('pages.time.overtime.create', compact('overtime'));
    }
    public function store(hris_overtime $overtime)
    {

    }
    public function edit(hris_overtime $overtime)
    {
        return view('pages.time.overtime.edit', compact('overtime'));
    }
    public function destroy(hris_overtime $overtime)
    {

    }
    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required|max:100'
        ]);
    }
}
