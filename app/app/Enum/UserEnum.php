<?php

namespace App\Enum;

enum UserEnum: string
{
    case ROLE_ADMIN     = 'ADMIN';
    case ROLE_LESSOR    = 'LESSOR';
    case ROLE_LESSEE    = 'LESSEE';

    case STATUS_INACTIVE    = '0';
    case STATUS_ACTIVE      = '1';
}
