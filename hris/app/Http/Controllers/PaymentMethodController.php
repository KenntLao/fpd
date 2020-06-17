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
        $paymentMethods = hris_payment_methods::paginate(10);
        return view('pages.admin.benefits.paymentMethods.index', compact('paymentMethods'));
    }

    public function create(hris_payment_methods $paymentMethod)
    {
        return view('pages.admin.benefits.paymentMethods.create', compact('paymentMethod'));
    }

    public function store(hris_payment_methods $paymentMethod, Request $request)
    {
        $action = 'add';
        $paymentMethod = new hris_payment_methods();
        if($this->validatedData()) {
            $paymentMethod = hris_payment_methods::create($this->validatedData());
            $id = $paymentMethod->id;
            $this->function->systemLog($this->module,$action,$id);
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
            $model = $paymentMethod;
            //DO systemLog function FROM SystemLogController
            $this->function->updateSystemLog($model,$this->module,$id);
            $paymentMethod->update($this->validatedData());
            return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully updated!');
        } else {
            return back()->with($this->validatedData());
        }
    }

    public function destroy(hris_payment_methods $paymentMethod)
    {
        $action = 'delete';
        $id = $_SESSION['sys_id'];
        $upass = $this->function->decryptStr(users::find($id)->upass);
        if ( $upass == request('upass') ) {
            $paymentMethod->delete();
            $id = $paymentMethod->id;
            $this->function->systemLog($this->module,$action,$id);
            return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment method successfully deleted!');
        } else {
            return back()->withErrors(['Password does not match.']);
        }
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }

}
