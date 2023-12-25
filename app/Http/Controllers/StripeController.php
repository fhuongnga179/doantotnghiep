<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('stripe.sk'));

        // Retrieve products from the cart
        $cartProducts = $request->session()->get('carts');

        if (empty($cartProducts)) {
            return response()->json(['error' => 'No products in the cart.']);
        }

        $lineItems = [];
        $totalAmountCents = 0;

        foreach ($cartProducts as $productId => $quantity) {
            $product = Product::find($productId);

            if (!$product) {
                return response()->json(['error' => 'Product not found.']);
            }

            // Convert the price to cents
            $unitAmountCents = $product->price * 1;

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'VND',
                    'product_data' => [
                        'name' => $product->name,
                    ],
                    'unit_amount' => $unitAmountCents,
                ],
                'quantity' => $quantity,
            ];

            $totalAmountCents += $unitAmountCents * $quantity;
        }

        // Check if the total amount exceeds the limit
        if ($totalAmountCents > 99999999) {
            return response()->json(['error' => 'Total amount exceeds the limit.']);
        }

        // Create a Stripe Checkout session with payment_method_types
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('success'),
            'cancel_url' => route('index'),
        ]);

        // Redirect to the Checkout session URL
        return redirect()->away($session->url);
    }

    public function success(Request $request)
    {
        // Clear the cart session
        $request->session()->forget('carts');

        return redirect()->back();
    }
}