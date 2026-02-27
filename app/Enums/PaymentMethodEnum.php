<?php

namespace App\Enums;

enum PaymentMethodEnum :string
{
    case CASH = 'cash';
    case BANK_TRANSFER = 'bank_transfer';
    case CREDIT_CARD = 'credit_card';
}
