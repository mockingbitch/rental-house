<?php

namespace App\Constants;

class CategoryConstant
{
    const MSG_NOT_FOUND = 'Category not found';
    const STATUS = 'status';
    const STATUS_VALUE_0 = 0;
    const STATUS_VALUE_1 = 1;
    public const TYPE = [
        self::STATUS_VALUE_0 => 'hide',
        self::STATUS_VALUE_1 => 'display',
    ];
}
