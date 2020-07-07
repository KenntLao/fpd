<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_leaves;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = hris_leaves::paginate(10);
        return view('pages.leaveManagement.leaves.index', compact('leaves'));
    }

    public function create()
    {

    }

    public function store(Request $request)
    {

    }

    public function show($id)
    {

    }

    public function edit($id)
    {

    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }

    
    
}
