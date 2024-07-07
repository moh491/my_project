<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class PaymentService
{
    public function confirm( $request)
    {
        $amount = $request['amount'];// amount in dollars
        // Convert amount to cents
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
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel', [], true),
        ]);

        return $session;
    }

    public function success(Request $request,$id)
    {
        $sessionId = $request->query('session_id');
        info($sessionId);
        // Set your Stripe secret key
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Retrieve the session
        $session = Session::retrieve($sessionId);

        // Retrieve payment intent to get payment details
        $paymentIntent = \Stripe\PaymentIntent::retrieve($session->payment_intent);

        // Store payment information in the database
        Payment::create([
            'payment_id' => $paymentIntent->id,
            'amount' => $paymentIntent->amount_received,
            'project_owner_id' => $id,
            'status' => 'paid',
            'session_id' => $sessionId,
        ]);

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
