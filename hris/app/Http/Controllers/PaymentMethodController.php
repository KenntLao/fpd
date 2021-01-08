<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\hris_payment_methods;
use App\users;

class PaymentMethodController extends Controller
{
    private $function;
    private $module;

    public function __construct() {
        $this->function = new FunctionController;
        $this->module = 'Benefits Administration - Payment Method';
    }
    public function index()
    {
        $paymentMethods = hris_payment_methods::where('del_status', 0)->paginate(10);
        return view('pages.admin.benefits.paymentMethods.index', compact('paymentMethods'));
    }

    public function create(hris_payment_methods $paymentMethod)
    {
        return view('pages.admin.benefits.paymentMethods.create', compact('paymentMethod'));
    }

    public function store(hris_payment_methods $paymentMethod, Request $request)
    {
        if($this->validatedData()) {
            $paymentMethod = hris_payment_methods::create($this->validatedData());
            $id = $paymentMethod->id;
            $this->function->addSystemLog($this->module,$id);
            return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully added!');
        } else {
            return back()->with($this->validatedData());
        }
    }

    public function show($id)
    {

    }

    public function edit(hris_payment_methods $paymentMethod)
    {
        return view('pages.admin.benefits.paymentMethods.edit', compact('paymentMethod'));
    }

    public function update(hris_payment_methods $paymentMethod, Request $request)
    {
        $id = $paymentMethod->id;
        if($this->validatedData()) {
            $string = 'App\hris_payment_methods';
            $paymentMethod->name = request('name');
            // GET CHANGES
            $changes = $paymentMethod->getDirty();
            // GET ORIGINAL DATA
            $this->function->getOldData($this->module,$string,$changes,$id);
            $paymentMethod->update();
            // GET CHANGES
            $changed = $paymentMethod->getChanges();
            // USE UPDATESYSTEMLOG FUNCTION
            $this->function->updateSystemLog($this->module,$changed,$string,$id);
            if ( $paymentMethod->wasChanged() ) {
                return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully updated!');
            } else {
                return redirect('/hris/pages/admin/benefits/paymentMethods/index');
            }
        } else {
            return back()->with($this->validatedData());
        }
    }

    public function destroy(hris_payment_methods $paymentMethod)
    {
        $id = $_SESSION['sys_id'];
        if ( $_SESSION['sys_account_mode'] == 'user' ) {
            $upass = $this->function->decryptStr(users::find($id)->upass);
            if ( $upass == request('upass') ) {
                $paymentMethod->del_status = 1;
                $paymentMethod->update();
                $id = $paymentMethod->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        } else {
            $employee = hris_employee::find($id);
            if ( Hash::check(request('upass'), $employee->password) ) {
                $paymentMethod->del_status = 1;
                $paymentMethod->update();
                $id = $paymentMethod->id;
                $this->function->deleteSystemLog($this->module,$id);
                return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully deleted!');
            } else {
                return back()->withErrors(['Password does not match.']);
            }
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }

}
