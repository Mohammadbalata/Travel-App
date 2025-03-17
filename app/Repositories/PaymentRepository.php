<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    public function creatPayment($userId,$itinerary_id,$sessionId,$amount,$currency,$payment_intent = null){
        return Payment::create([
            'user_id' => $userId,
            'itinerary_id' => $itinerary_id,
            'payment_session_id' => $sessionId,
            'payment_intent' => $payment_intent,
            'amount' => $amount,
            'currency' => $currency,
        ]);
    }


    public function getPaymentBySessionId($sessionId){
        return Payment::where('payment_session_id', $sessionId)->first();
    }
}
