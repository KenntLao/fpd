<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\hris_time_sheets;

class TimeSheetController extends Controller
{
    public function index()
    {
        $timeSheets = hris_time_sheets::paginate(10);
        return view('pages.time.timeSheets.index', compact('timeSheets'));
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
