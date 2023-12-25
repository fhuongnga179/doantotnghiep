<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
// use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Api\PaymentExecution;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Payment;

class PayPalController extends Controller
{
    public function paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $responsive = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success'),
                "cancel_url" => route('cancel'),

            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ],
                ],
            ],
        ]);
        // dd($responsive);
        if (isset($responsive['id']) && $responsive['id'] != null) {
            foreach ($responsive['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    session()->put('product_name', $request->product_name);
                    session()->put('quantity', $request->quantity);

                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success_paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {


            $payment = new Payment;
            $payment->payment_id = $response['id'];
            $payment->product_name = $response['product_name'];
            $payment->quantity = $response['quantity'];
            $payment->amount = $response['purchase_units'][0]['payment']['captures'][0]['amount']['value'];
            $payment->currency = $response['purchase_units'][0]['payment']['captures'][0]['amount']['currency_code'];


            $payment->payer_name = $response['payer']['name']['give_name'];
            $payment->payer_email = $response['payer']['email_address'];
            $payment->payment_status = $response['status'];
            $payment->save;

            return "Đơn hàng của bạn đã được gửi đi";
            unset($_SESSION['product_name']);
            unset($_SESSION['quantity']);
        } else {
            return redirect()->route('cancel');
        }
    }

    public function cancel()
    {
        return "Thanh toán hủy bỏ";
    }
}