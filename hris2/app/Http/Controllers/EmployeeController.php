<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_employee;
class EmployeeController extends Controller
{
//
    public function index(){
        $employees = hris_employee::paginate(10);
        return view('pages.employees.employee.index', compact('employees'));
    }
}
