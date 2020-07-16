<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_itenerary_requests;
use App\hris_employee;
use App\users;
use App\roles;
use App\hris_currencies;

class IteneraryRequestController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Employee Management - Itenerary Request';
    }
    public function index()
    {
        $id = $_SESSION['sys_id'];
        if ($_SESSION['sys_role_ids'] == ',1,' ) {
            $iteneraryRequests = hris_itenerary_requests::paginate(10);
            return view('pages.employees.iteneraryRequests.index', compact('iteneraryRequests'));
        } else {
            $roles = roles::all();
            $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
            $supervisor_id = implode(' ', $supervisor_role_id[0]);
            $find = hris_employee::find($id);
            $role_ids = explode(',', $find->role_id);

            if ( in_array($supervisor_id, $role_ids) ) {
                $department = $find->department_id;
                $employee = hris_employee::all()->where('department_id', $department)->where('supervisor', $id);
                $employee_id = array();
                foreach ($employee as $e) {
                    $employee_id[] = $e->id;
                }
                $iteneraryRequests = hris_itenerary_requests::whereIn('employee_id', $employee_id)->paginate(10);
                $self = hris_itenerary_requests::where('employee_id', $_SESSION['sys_id'])->paginate(10);
                return view('pages.employees.iteneraryRequests.index', compact('iteneraryRequests','role_ids', 'supervisor_id', 'self'));
            } else {
                $iteneraryRequests = hris_itenerary_requests::where('employee_id', $id)->paginate(10);
                return view('pages.employees.iteneraryRequests.index', compact('iteneraryRequests','role_ids', 'supervisor_id'));
            }

        }
    }

    public function create(hris_itenerary_requests $iteneraryRequest)
    {
        $currencies = hris_currencies::all();
        return view('pages.employees.iteneraryRequests.create', compact('iteneraryRequest', 'currencies'));
    }

    public function store(hris_itenerary_requests $iteneraryRequest, Request $request)
    {
        $id = $_SESSION['sys_id'];
        $employee = hris_employee::find($id);
        if ( $employee->supervisor == NULL ) {
            return back()->withErrors(['Employee supervisor is required']);
        } else {
            if ( $this->validatedData() ) {
                if($request->hasFile('attachment_1')) {
                    $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                    $iteneraryRequest->attachment_1 = $attachment_1;
                    $request->attachment_1->move(public_path('assets/files/employees/itenerary_requests'), $attachment_1);
                }
                if($request->hasFile('attachment_2')) {
                    $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                    $iteneraryRequest->attachment_2 = $attachment_2;
                    $request->attachment_2->move(public_path('assets/files/employees/itenerary_requests'), $attachment_2);
                }
                if($request->hasFile('attachment_3')) {
                    $attachment_3 = time() . 'A3.' . $request->attachment_3->extension();
                    $iteneraryRequest->attachment_3 = $attachment_3;
                    $request->attachment_3->move(public_path('assets/files/employees/itenerary_requests'), $attachment_3);
                }
                $iteneraryRequest->employee_id = $id;
                $iteneraryRequest->transportation = request('transportation');
                $iteneraryRequest->purpose = request('purpose');
                $iteneraryRequest->travel_from = request('travel_from');
                $iteneraryRequest->travel_to = request('travel_to');
                $iteneraryRequest->travel_date = request('travel_date');
                $iteneraryRequest->return_date = request('return_date');
                $iteneraryRequest->notes = request('notes');
                $iteneraryRequest->currency_id = request('currency_id');
                $iteneraryRequest->total_funding_proposed = request('total_funding_proposed');
                $iteneraryRequest->status = '0';
                $iteneraryRequest->save();

                /* SYSTEM LOG */
                $id = $iteneraryRequest->id;
                $this->function->addSystemLog($this->module,$id);
                
                return redirect('/hris/pages/employees/iteneraryRequests/index')->with('success', 'Itenerary request successfully added!');
            } else {
                return back()->withErrors($this->validatedData());
            }
        }
        
    }

    public function show(hris_itenerary_requests $iteneraryRequest)
    {
        $id = $_SESSION['sys_id'];
        if( $iteneraryRequest->role_id == ',1,' ) {
            if ( $iteneraryRequest->supervisor_id != NULL ) {
                $users = users::find($iteneraryRequest->supervisor_id);
                $user = $users->uname;
            } else {
                $user = 'Pending';
            }
        } else {
            if ( $iteneraryRequest->supervisor_id != NULL ) {
                $user = $iteneraryRequest->supervisor->firstname.' '.$iteneraryRequest->supervisor->lastname;
            } else {
                $user = 'Pending';
            }
        }
        $currencies = hris_currencies::all();
        return view('pages.employees.iteneraryRequests.show', compact('iteneraryRequest', 'currencies', 'user'));
    }

    public function edit(hris_itenerary_requests $iteneraryRequest)
    {
        $id = $_SESSION['sys_id'];
        if ( $id == $iteneraryRequest->supervisor_id ) {
            return redirect()->back();
        } else {
            $currencies = hris_currencies::all();
            return view('pages.employees.iteneraryRequests.edit', compact('iteneraryRequest', 'currencies'));
        }
    }

    public function update(hris_itenerary_requests $iteneraryRequest, Request $request)
    {
        $id = $iteneraryRequest->id;
        $string = 'App\hris_itenerary_requests';
        if ($this->validatedData()) {
            $model = $iteneraryRequest;
            if( $request->hasFile('attachment_1') ) {
                $path = public_path('assets/files/employees/itenerary_requests/');
                if ($iteneraryRequest->attachment_1 != '' && $iteneraryRequest->attachment_1 != NULL) {
                    $old = $path . $iteneraryRequest->attachment_1;
                    unlink($old);
                    $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                    $iteneraryRequest->attachment_1 = $attachment_1;
                    $request->attachment_1->move($path, $attachment_1);
                } else {
                    $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                    $iteneraryRequest->attachment_1 = $attachment_1;
                    $request->attachment_1->move($path, $attachment_1);
                }
            }
            if( $request->hasFile('attachment_1') ) {
                $path = public_path('assets/files/employees/itenerary_requests/');
                if ($iteneraryRequest->attachment_2 != '' && $iteneraryRequest->attachment_2 != NULL) {
                    $old = $path . $iteneraryRequest->attachment_2;
                    unlink($old);
                    $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                    $iteneraryRequest->attachment_2 = $attachment_2;
                    $request->attachment_2->move($path, $attachment_2);
                } else {
                    $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                    $iteneraryRequest->attachment_2 = $attachment_2;
                    $request->attachment_2->move($path, $attachment_2);
                }
            }
            if( $request->hasFile('attachment_3') ) {
                $path = public_path('assets/files/employees/itenerary_requests/');
                if ($iteneraryRequest->attachment_3 != '' && $iteneraryRequest->attachment_3 != NULL) {
                    $old = $path . $iteneraryRequest->attachment_3;
                    unlink($old);
                    $attachment_3 = time() . 'A3.' . $request->attachment_3->extension();
                    $iteneraryRequest->attachment_3 = $attachment_3;
                    $request->attachment_3->move($path, $attachment_3);
                } else {
                    $attachment_3 = time() . 'A3.' . $request->attachment_3->extension();
                    $iteneraryRequest->attachment_3 = $attachment_3;
                    $request->attachment_3->move($path, $attachment_3);
                }
            }
            $iteneraryRequest->transportation = request('transportation');
            $iteneraryRequest->purpose = request('purpose');
            $iteneraryRequest->travel_from = request('travel_from');
            $iteneraryRequest->travel_to = request('travel_to');
            $iteneraryRequest->travel_date = request('travel_date');
            $iteneraryRequest->return_date = request('return_date');
            $iteneraryRequest->notes = request('notes');
            $iteneraryRequest->currency_id = request('currency_id');
            $iteneraryRequest->total_funding_proposed = request('total_funding_proposed');
            // GET CHANGES
            $changes = $iteneraryRequest->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $iteneraryRequest->update();
            // GET CHANGES
            $changed = $iteneraryRequest->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $iteneraryRequest->wasChanged() ) {
                return redirect('/hris/pages/employees/iteneraryRequests/index')->with('success', 'Itenerary request successfully updated!');
            } else {
                return redirect('/hris/pages/employees/iteneraryRequests/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function updateStatus($status, hris_itenerary_requests $iteneraryRequest)
    {
        $id = $_SESSION['sys_id'];
        $string = 'App\hris_itenerary_requests';
        $employee_id = $iteneraryRequest->employee_id;
        $employee = hris_employee::find($employee_id);
        $roles = roles::all();
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $employee_supervisor = hris_employee::all()->where('role_id', ','.$supervisor_id.',')->where('department_id', $employee->department_id);
        $es_id = array();
        foreach ($employee_supervisor as $es) {
            $es_id[] = $es->id;
        }
        if ( $id == $iteneraryRequest->employee_id ) {
            return back()->withErrors(['You do not have permission to access this page.']);
        } else {
            if ( $_SESSION['sys_role_ids'] == ',1,' ) {
                $id = $iteneraryRequest->id;
                $this->function->statusSystemLog($this->module,$string,$id);
                if ( $status == '1' OR $status == '2' ) {
                    if ( $status == '1' ) {
                    $msg = 'accepted';
                    }
                    if ( $status == '2' ) {
                    $msg = 'rejected';
                    }
                    $overtime->status = $status;
                } else {
                    return redirect('/hris/pages/employees/iteneraryRequests/index')->withErrors(['Invalid status!']);
                }
                $iteneraryRequest->supervisor_id = $_SESSION['sys_id'];
                $iteneraryRequest->role_id = $_SESSION['sys_role_ids'];
                $iteneraryRequest->update();
                return redirect('/hris/pages/employees/iteneraryRequests/index')->with('success', 'Itenerary request '.$string.'!');
            } else {
                if (in_array($id, $es_id)) {
                    $id = $iteneraryRequest->id;
                    $this->function->statusSystemLog($this->module,$string,$id);
                    if ( $status == '1' OR $status == '2' ) {
                        if ( $status == '1' ) {
                            $msg = 'accepted';
                        }
                        if ( $status == '2' ) {
                            $msg = 'rejected';
                        }
                        $iteneraryRequest->status = $status;
                    } else {
                        return redirect('/hris/pages/employees/iteneraryRequests/index')->withErrors(['Invalid status!']);
                    }
                    $iteneraryRequest->supervisor_id = $_SESSION['sys_id'];
                    $iteneraryRequest->role_id = $_SESSION['sys_role_ids'];
                    $iteneraryRequest->update();
                    return redirect('/hris/pages/employees/iteneraryRequests/index')->with('success', 'Itenerary request '.$msg.'!');
                }
            }
        }
    }

    public function download($attachment, hris_itenerary_requests $iteneraryRequest)
    {   
        if ( $attachment == 1 ) {
            $file = public_path('assets/files/employees/itenerary_requests/'.$iteneraryRequest->attachment_1);
            return response()->download($file);
        }   
        if ( $attachment == 2 ) {
            $file = public_path('assets/files/employees/itenerary_requests/'.$iteneraryRequest->attachment_2);
            return response()->download($file);
        }   
        if ( $attachment == 3 ) {
            $file = public_path('assets/files/employees/itenerary_requests/'.$iteneraryRequest->attachment_3);
            return response()->download($file);
        }
    }

    public function destroy(hris_itenerary_requests $iteneraryRequest)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_role_ids'] == ',1,' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $iteneraryRequest->delete();
                $id = $iteneraryRequest->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/iteneraryRequests/index')->with('success','Itenerary request successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $iteneraryRequest->delete();
                $id = $iteneraryRequest->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/iteneraryRequests/index')->with('success', 'Itenerary request successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }
    protected function validatedData()
    {
        return request()->validate([
            'transportation' => 'required',
            'purpose' => 'required',
            'travel_from' => 'required',
            'travel_to' => 'required',
            'travel_date' => 'required|date_format:Y-m-d h:i A',
            'return_date' => 'required|date_format:Y-m-d h:i A|after:travel_date',
            'notes' => 'nullable',
            'currency_id' => 'required',
            'total_funding_proposed' => 'required',
            'attachment_1' => 'nullable',
            'attachment_2' => 'nullable',
            'attachment_3' => 'nullable',
            'status' => 'nullable',
        ]);
    }
}
