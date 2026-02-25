<?php

namespace App\Enums;

enum ContractStatusEnum : string
{
    case DRAFT = 'draft';
    case ACTIVE = 'active';
    case EXPIRED = 'expired';
    case TERMINATED = 'terminated';
}
