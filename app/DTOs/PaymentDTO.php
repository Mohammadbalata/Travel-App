<?php

namespace App\DTOs;

class PaymentDTO
{
    public function __construct(
        public int $userId,
        public int $itineraryId,
        public string $sessionId,
        public float $amount,
        public string $currency,
        public ?string $paymentIntent = null
    ) {}

    public function toArray(): array
    {
        return [
            'user_id'           => $this->userId,
            'itinerary_id'      => $this->itineraryId,
            'payment_session_id' => $this->sessionId,
            'amount'            => $this->amount,
            'currency'          => $this->currency,
            'payment_intent'    => $this->paymentIntent,
        ];
    }
}
