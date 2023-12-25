<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function createPayment(Request $request)
    {
        $user = $request->user();
        $payment = $user->charge(100, 'paypal');

        return redirect($payment->getCheckoutUrl());
    }
}
