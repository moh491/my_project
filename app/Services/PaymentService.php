<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Project_Owners;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentService
{
    public function confirm(Request $request)
    {
        $amount = $request->input('amount'); // amount in dollars
        $price = $request->input('price'); // amount in dollars
        $amountInCents = $amount * 100;

        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        // Create a checkout session
        $session = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'payment_intent_data' => [
                'description' => 'Payment of Hirelo',
                'setup_future_usage' => 'off_session',
            ],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => 'Payment of Hirelo',
                    ],
                    'unit_amount' => $amountInCents,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}&price=' . $price . '&token=' . $request->bearerToken(),
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        return $session;
    }

    public function success(Request $request,$id)
    {
        $sessionId = $request->query('session_id');
        $price = $request->query('price');
        info($price);
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the session
        $session = Session::retrieve($sessionId);

        // Retrieve payment intent to get payment details
        $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

        // Store payment information in the database
        Payment::create([
            'payment_id' => $paymentIntent->id,
            'amount' => $price,
            'project_owner_id' => $id,
            'status' => 'paid',
            'session_id' => $sessionId,
        ]);
        $project_owner= Project_Owners::find($id);
        $project_owner->update(['withdrawal_balance'=> $project_owner->withdrawal_balance + $price]);
    }

    public function refund($request, $id): \Stripe\Refund
    {

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the Checkout Session by the session id
        $session = \Stripe\Checkout\Session::retrieve($request['session_id']);

        // Get the PaymentIntent id
        $paymentIntentId = $session->payment_intent;

        // Retrieve the PaymentIntent by the id
        $paymentIntent = \Stripe\PaymentIntent::retrieve($paymentIntentId);

        if (isset($request['amount'])) {
            $refund = \Stripe\Refund::create([
                'payment_intent' => $paymentIntentId,
                'amount' => $request['amount'],
            ]);

        } else {
            // Refund the PaymentIntent
            $refund = \Stripe\Refund::create([
                'payment_intent' => $paymentIntentId,
            ]);
        }

        Payment::create([
            'session_id' => $request['session_id'],
            'refund_id' => $refund->id,
            'status' => 'refunded',
            'amount' => $refund->amount,
            'project_owner_id' => $id
        ]);


        return $refund;
    }


}
