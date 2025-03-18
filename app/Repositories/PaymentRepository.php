<?php

namespace App\Repositories;

use App\Models\Payment;

class PaymentRepository
{
    public function creatPayment(array $paymentData)
    {
        return Payment::create($paymentData);
    }


    public function getPaymentBySessionId($sessionId)
    {
        return Payment::where('payment_session_id', $sessionId)->first();
    }
}
