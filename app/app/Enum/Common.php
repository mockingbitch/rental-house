<?php

namespace App\Enum;

enum Common: string
{
    case V_LESSOR       = 'VERIFIED';
    case ROLE_LESSOR    = 'LESSOR';
    case ROLE_LESSEE    = 'LESSEE';
}
