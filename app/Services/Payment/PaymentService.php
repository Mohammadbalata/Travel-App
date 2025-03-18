<?php

namespace App\Services\Payment;

use App\DTOs\PaymentDTO;
use App\Enums\PaymentStausEnum;
use App\Helpers\Currency;
use App\Repositories\PaymentRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session as FacadesSession;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentService
{
    protected $apiKey;
    public function __construct(protected PaymentRepository $paymentRepository)
    {
        $this->apiKey = config('services.stripe.secret_key');
        Stripe::setApiKey($this->apiKey);
    }


    public function handlePayment($request)
    {
        $request->validate([
            'amount' => 'required',
            'itinerary_id' => 'required|exists:itineraries,id',
        ]);

        $amount = Currency::convert($request->input('amount'));
        $currency = FacadesSession::get('currency_code', 'EUR');
        $itinerary_id = $request->input('itinerary_id');

        $session = $this->createCheckoutSession($amount, $currency);

        $paymentData = new PaymentDTO(
            Auth::id(),
            $itinerary_id,
            $session->id,
            $amount,
            $currency,
        );

        $payment = $this->paymentRepository->creatPayment($paymentData->toArray());

        return redirect($session->url);
    }


    public function success($request)
    {
        $sessionId = $request->get('session_id');
        try {
            $session = Session::retrieve($sessionId);
            if (!$session) {
                throw new NotFoundHttpException;
            }
            $payment = $this->paymentRepository->getPaymentBySessionId($session->id);
            if (!$payment) {
                throw new NotFoundHttpException;
            }
            if ($payment->status == PaymentStausEnum::Pending->value) {
                $payment->status = PaymentStausEnum::Paid;
                $payment->save();
            }

            return redirect()->route('itineraries.show', $payment->itinerary_id)->with('success', 'payment proccess succeseded');
        } catch (\Exception $e) {
            throw new NotFoundHttpException();
        }
    }

    public function cancel()
    {
        return;
    }

    public function webhook()
    {
        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sig_header,
                $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 400);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;

                $payment = $this->paymentRepository->getPaymentBySessionId($session->id);
                if ($payment && $payment->status === PaymentStausEnum::Pending->value) {
                    $payment->status = PaymentStausEnum::Paid;
                    $payment->save();
                }

                // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('');
    }

    public function createCheckoutSession($amount, $currency = 'usd')
    {
        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => ['name' => 'Travel Package'],
                    'unit_amount' => $amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' =>  route('payment.cancel'),

        ]);
    }
}
