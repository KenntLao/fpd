<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\hris_itinerary_requests;
use App\hris_employee;
use App\users;
use App\roles;
use App\hris_currencies;

class ItineraryRequestController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Employee Management - Itinerary Request';
    }
    public function index()
    {
        $id = $_SESSION['sys_id'];
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $roles = explode(',', $_SESSION['sys_role_ids']);
        if ($_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $roles) ) {
            $itineraryRequests = hris_itinerary_requests::where('del_status', 0)->paginate(10);
            return view('pages.employees.itineraryRequests.index', compact('itineraryRequests'));
        } else {
            $roles = roles::all();
            $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
            $supervisor_id = implode(' ', $supervisor_role_id[0]);
            $find = hris_employee::find($id);
            $role_ids = explode(',', $find->role_id);

            if ( in_array($supervisor_id, $role_ids) ) {
                $department = $find->department_id;
                $employee = hris_employee::all()->where('department_id', $department)->where('supervisor', $id)->where('del_status', 0);
                $employee_id = array();
                foreach ($employee as $e) {
                    $employee_id[] = $e->id;
                }
                $itineraryRequests = hris_itinerary_requests::whereIn('employee_id', $employee_id)->where('del_status', 0)->paginate(10);
                $self = hris_itinerary_requests::where('employee_id', $_SESSION['sys_id'])->paginate(10);
                return view('pages.employees.itineraryRequests.index', compact('itineraryRequests','role_ids', 'supervisor_id', 'self'));
            } else {
                $itineraryRequests = hris_itinerary_requests::where('employee_id', $id)->where('del_status', 0)->paginate(10);
                return view('pages.employees.itineraryRequests.index', compact('itineraryRequests','role_ids', 'supervisor_id'));
            }

        }
    }

    public function create(hris_itinerary_requests $itineraryRequest)
    {
        $currencies = hris_currencies::all();
        $employees = hris_employee::where('del_status', 0)->get();
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $roles = explode(',', $_SESSION['sys_role_ids']);
        return view('pages.employees.itineraryRequests.create', compact('itineraryRequest', 'currencies', 'employees', 'hr_officer_id', 'roles'));
    }

    public function store(hris_itinerary_requests $itineraryRequest, Request $request)
    {
        $id = $_SESSION['sys_id'];
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $roles = explode(',', $_SESSION['sys_role_ids']);
        if ( $_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $roles) ) {
            $employee = hris_employee::find(request('employee_id'));
            if ( $employee->supervisor == NULL ) {
                return back()->withErrors(['Employee supervisor is required']);
            } else {
                if ( $this->validatedData() ) {
                    if($request->hasFile('attachment_1')) {
                        $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                        $itineraryRequest->attachment_1 = $attachment_1;
                        $request->attachment_1->move(public_path('assets/files/employees/itenerary_requests'), $attachment_1);
                    }
                    if($request->hasFile('attachment_2')) {
                        $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                        $itineraryRequest->attachment_2 = $attachment_2;
                        $request->attachment_2->move(public_path('assets/files/employees/itenerary_requests'), $attachment_2);
                    }
                    if($request->hasFile('attachment_3')) {
                        $attachment_3 = time() . 'A3.' . $request->attachment_3->extension();
                        $itineraryRequest->attachment_3 = $attachment_3;
                        $request->attachment_3->move(public_path('assets/files/employees/itenerary_requests'), $attachment_3);
                    }
                    $itineraryRequest->employee_id = request('employee_id');
                    $itineraryRequest->transportation = request('transportation');
                    $itineraryRequest->purpose = request('purpose');
                    $itineraryRequest->travel_from = request('travel_from');
                    $itineraryRequest->travel_to = request('travel_to');
                    $itineraryRequest->travel_date = request('travel_date');
                    $itineraryRequest->return_date = request('return_date');
                    $itineraryRequest->notes = request('notes');
                    $itineraryRequest->currency_id = request('currency_id');
                    $itineraryRequest->total_funding_proposed = request('total_funding_proposed');
                    $itineraryRequest->status = '0';
                    $itineraryRequest->del_status = 0;
                    $itineraryRequest->save();

                    /* SYSTEM LOG */
                    $id = $itineraryRequest->id;
                    $this->function->addSystemLog($this->module,$id);
                    
                    return redirect('/hris/pages/employees/itineraryRequests/index')->with('success', 'Itenerary request successfully added!');
                } else {
                    return back()->withErrors($this->validatedData());
                }
            }

        } else {
            $employee = hris_employee::find($id);
            if ( $employee->supervisor == NULL ) {
                return back()->withErrors(['Employee supervisor is required']);
            } else {
                if ( $this->validatedData() ) {
                    if($request->hasFile('attachment_1')) {
                        $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                        $itineraryRequest->attachment_1 = $attachment_1;
                        $request->attachment_1->move(public_path('assets/files/employees/itenerary_requests'), $attachment_1);
                    }
                    if($request->hasFile('attachment_2')) {
                        $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                        $itineraryRequest->attachment_2 = $attachment_2;
                        $request->attachment_2->move(public_path('assets/files/employees/itenerary_requests'), $attachment_2);
                    }
                    if($request->hasFile('attachment_3')) {
                        $attachment_3 = time() . 'A3.' . $request->attachment_3->extension();
                        $itineraryRequest->attachment_3 = $attachment_3;
                        $request->attachment_3->move(public_path('assets/files/employees/itenerary_requests'), $attachment_3);
                    }
                    $itineraryRequest->employee_id = $id;
                    $itineraryRequest->transportation = request('transportation');
                    $itineraryRequest->purpose = request('purpose');
                    $itineraryRequest->travel_from = request('travel_from');
                    $itineraryRequest->travel_to = request('travel_to');
                    $itineraryRequest->travel_date = request('travel_date');
                    $itineraryRequest->return_date = request('return_date');
                    $itineraryRequest->notes = request('notes');
                    $itineraryRequest->currency_id = request('currency_id');
                    $itineraryRequest->total_funding_proposed = request('total_funding_proposed');
                    $itineraryRequest->status = '0';
                    $itineraryRequest->save();

                    /* SYSTEM LOG */
                    $id = $itineraryRequest->id;
                    $this->function->addSystemLog($this->module,$id);
                    
                    return redirect('/hris/pages/employees/itineraryRequests/index')->with('success', 'Itenerary request successfully added!');
                } else {
                    return back()->withErrors($this->validatedData());
                }
            }
        }
        
    }

    public function show(hris_itinerary_requests $itineraryRequest)
    {
        $id = $_SESSION['sys_id'];
        if( $itineraryRequest->role_id == ',1,' ) {
            if ( $itineraryRequest->supervisor_id != NULL ) {
                $users = users::find($itineraryRequest->supervisor_id);
                $user = $users->uname;
            } else {
                $user = '---';
            }
        } else {
            if ( $itineraryRequest->supervisor_id != NULL ) {
                $user = $itineraryRequest->supervisor->firstname.' '.$itineraryRequest->supervisor->lastname;
            } else {
                $user = '---';
            }
        }
        $currencies = hris_currencies::all();
        return view('pages.employees.itineraryRequests.show', compact('itineraryRequest', 'currencies', 'user'));
    }

    public function edit(hris_itinerary_requests $itineraryRequest)
    {
        $id = $_SESSION['sys_id'];
        if ( $id == $itineraryRequest->supervisor_id ) {
            return redirect()->back();
        } else {
            $currencies = hris_currencies::all();
            $employees = hris_employee::where('del_status', 0)->get();
            $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
            $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
            $roles = explode(',', $_SESSION['sys_role_ids']);
            return view('pages.employees.itineraryRequests.edit', compact('itineraryRequest', 'currencies', 'hr_officer_id', 'roles', 'employees'));
        }
    }

    public function update(hris_itinerary_requests $itineraryRequest, Request $request)
    {
        $id = $itineraryRequest->id;
        $string = 'App\hris_itinerary_requests';
        if ($this->validatedData()) {
            $model = $itineraryRequest;
            if( $request->hasFile('attachment_1') ) {
                $path = public_path('assets/files/employees/itenerary_requests/');
                if ($itineraryRequest->attachment_1 != '' && $itineraryRequest->attachment_1 != NULL) {
                    $old = $path . $itineraryRequest->attachment_1;
                    unlink($old);
                    $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                    $itineraryRequest->attachment_1 = $attachment_1;
                    $request->attachment_1->move($path, $attachment_1);
                } else {
                    $attachment_1 = time() . 'A1.' . $request->attachment_1->extension();
                    $itineraryRequest->attachment_1 = $attachment_1;
                    $request->attachment_1->move($path, $attachment_1);
                }
            }
            if( $request->hasFile('attachment_1') ) {
                $path = public_path('assets/files/employees/itenerary_requests/');
                if ($itineraryRequest->attachment_2 != '' && $itineraryRequest->attachment_2 != NULL) {
                    $old = $path . $itineraryRequest->attachment_2;
                    unlink($old);
                    $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                    $itineraryRequest->attachment_2 = $attachment_2;
                    $request->attachment_2->move($path, $attachment_2);
                } else {
                    $attachment_2 = time() . 'A2.' . $request->attachment_2->extension();
                    $itineraryRequest->attachment_2 = $attachment_2;
                    $request->attachment_2->move($path, $attachment_2);
                }
            }
            if( $request->hasFile('attachment_3') ) {
                $path = public_path('assets/files/employees/itenerary_requests/');
                if ($itineraryRequest->attachment_3 != '' && $itineraryRequest->attachment_3 != NULL) {
                    $old = $path . $itineraryRequest->attachment_3;
                    unlink($old);
                    $attachment_3 = time() . 'A3.' . $request->attachment_3->extension();
                    $itineraryRequest->attachment_3 = $attachment_3;
                    $request->attachment_3->move($path, $attachment_3);
                } else {
                    $attachment_3 = time() . 'A3.' . $request->attachment_3->extension();
                    $itineraryRequest->attachment_3 = $attachment_3;
                    $request->attachment_3->move($path, $attachment_3);
                }
            }
            $itineraryRequest->transportation = request('transportation');
            $itineraryRequest->purpose = request('purpose');
            $itineraryRequest->travel_from = request('travel_from');
            $itineraryRequest->travel_to = request('travel_to');
            $itineraryRequest->travel_date = request('travel_date');
            $itineraryRequest->return_date = request('return_date');
            $itineraryRequest->notes = request('notes');
            $itineraryRequest->currency_id = request('currency_id');
            $itineraryRequest->total_funding_proposed = request('total_funding_proposed');
            // GET CHANGES
            $changes = $itineraryRequest->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $itineraryRequest->update();
            // GET CHANGES
            $changed = $itineraryRequest->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $itineraryRequest->wasChanged() ) {
                return redirect('/hris/pages/employees/itineraryRequests/index')->with('success', 'Itenerary request successfully updated!');
            } else {
                return redirect('/hris/pages/employees/itineraryRequests/index');
            }
        } else {
            return back()->withErrors($this->validatedData());
        }
    }

    public function updateStatus($status, hris_itinerary_requests $itineraryRequest)
    {
        $id = $_SESSION['sys_id'];
        $string = 'App\hris_itinerary_requests';
        $employee_id = $itineraryRequest->employee_id;
        $employee = hris_employee::find($employee_id);
        $roles = roles::all();
        $hr_officer_role_id = roles::where('role_name', 'hr officer')->get('id')->toArray();
        $hr_officer_id = implode(' ', $hr_officer_role_id[0]);
        $sys_roles = explode(',', $_SESSION['sys_role_ids']);
        $supervisor_role_id = roles::where('role_name', 'supervisor')->get('id')->toArray();
        $supervisor_id = implode(' ', $supervisor_role_id[0]);
        $employee_supervisor = hris_employee::all()->where('role_id', ','.$supervisor_id.',')->where('department_id', $employee->department_id);
        $es_id = array();
        foreach ($employee_supervisor as $es) {
            $es_id[] = $es->id;
        }
        if ( $id == $itineraryRequest->employee_id ) {
            return back()->withErrors(['You do not have permission to access this page.']);
        } else {
            if ( $_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $sys_roles) ) {
                $id = $itineraryRequest->id;
                $this->function->statusSystemLog($this->module,$string,$id);
                if ( $status == '1' OR $status == '2' ) {
                    if ( $status == '1' ) {
                    $msg = 'approved';
                    }
                    if ( $status == '2' ) {
                    $msg = 'denied';
                    }
                    $itineraryRequest->status = $status;
                } else {
                    return redirect('/hris/pages/employees/itineraryRequests/index')->withErrors(['Invalid status!']);
                }
                $itineraryRequest->supervisor_id = $_SESSION['sys_id'];
                $itineraryRequest->role_id = $_SESSION['sys_role_ids'];
                $itineraryRequest->update();
                return redirect('/hris/pages/employees/itineraryRequests/index')->with('success', 'Itenerary request '.$string.'!');
            } else {
                if (in_array($id, $es_id)) {
                    $id = $itineraryRequest->id;
                    $this->function->statusSystemLog($this->module,$string,$id);
                    if ( $status == '1' OR $status == '2' ) {
                        if ( $status == '1' ) {
                            $msg = 'approved';
                        }
                        if ( $status == '2' ) {
                            $msg = 'denied';
                        }
                        $itineraryRequest->status = $status;
                    } else {
                        return redirect('/hris/pages/employees/itineraryRequests/index')->withErrors(['Invalid status!']);
                    }
                    $itineraryRequest->supervisor_id = $_SESSION['sys_id'];
                    $itineraryRequest->role_id = $_SESSION['sys_role_ids'];
                    $itineraryRequest->update();
                    return redirect('/hris/pages/employees/itineraryRequests/index')->with('success', 'Itenerary request '.$msg.'!');
                }
            }
        }
    }

    public function download($attachment, hris_itinerary_requests $itineraryRequest)
    {   
        if ( $attachment == 1 ) {
            $file = public_path('assets/files/employees/itenerary_requests/'.$itineraryRequest->attachment_1);
            return response()->download($file);
        }   
        if ( $attachment == 2 ) {
            $file = public_path('assets/files/employees/itenerary_requests/'.$itineraryRequest->attachment_2);
            return response()->download($file);
        }   
        if ( $attachment == 3 ) {
            $file = public_path('assets/files/employees/itenerary_requests/'.$itineraryRequest->attachment_3);
            return response()->download($file);
        }
    }

    public function destroy(hris_itinerary_requests $itineraryRequest)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $itineraryRequest->del_status = 1;
                $itineraryRequest->update();
                $id = $itineraryRequest->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/itineraryRequests/index')->with('success','Itenerary request successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $itineraryRequest->del_status = 1;
                $itineraryRequest->update();
                $id = $itineraryRequest->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/employees/itineraryRequests/index')->with('success', 'Itenerary request successfully deleted!');
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
            'total_funding_proposed' => 'required|integer',
            'attachment_1' => 'nullable',
            'attachment_2' => 'nullable',
            'attachment_3' => 'nullable',
            'status' => 'nullable',
        ]);
    }
}
