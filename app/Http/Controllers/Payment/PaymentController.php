<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\Payment\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{


    public function __construct(protected PaymentService $paymentService) {}

    public function handlePayment(Request $request)
    {
       return $this->paymentService->handlePayment($request);
    }

    public function success(Request $request)
    {
       return $this->paymentService->success($request);  
    }

    public function cancel()
    {
        return $this->paymentService->cancel();

    }

    public function webhook(){
       return $this->paymentService->webhook();
    }
}
