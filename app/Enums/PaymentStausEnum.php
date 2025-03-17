<?php

namespace App\Enums;


enum PaymentStausEnum: string
{
    case Pending = 'pending';
    case Paid = 'paid';
    case Faild = 'failed';
    case Refund = 'refund';
}
