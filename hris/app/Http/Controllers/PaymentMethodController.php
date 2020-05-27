<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\hris_payment_methods;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = hris_payment_methods::paginate(10);
        return view('pages.admin.benefits.paymentMethods.index', compact('paymentMethods'));
    }

    public function create(hris_payment_methods $paymentMethod)
    {
        return view('pages.admin.benefits.paymentMethods.create', compact('paymentMethod'));
    }

    public function store(Request $request)
    {
        $paymentMethod = new hris_payment_methods();
        if($this->validatedData()) {
            $paymentMethod->name = request('name');
            $paymentMethod->save();
            return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment Method successfully added!');
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
        if($this->validatedData()) {
            $paymentMethod->name = request('name');
            $paymentMethod->update();
            return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment Method successfully updated!');
        } else {
            return back()->with($this->validatedData());
        }
    }

    public function destroy(hris_payment_methods $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect('/hris/pages/admin/benefits/paymentMethods/index')->with('success', 'Payment Method successfully deleted!');
    }

    protected function validatedData()
    {
        return request()->validate([
            'name' => 'required'
        ]);
    }

}
