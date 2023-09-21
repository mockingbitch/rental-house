<?php

namespace App\Constants;

class CommonConstants
{
    public const TBL_NAME = 'users';

    public const ROLE_ADMIN     = 1;
    public const ROLE_TEACHER   = 2;
    public const ROLE_PARENT    = 3;

    public const COL_ID = 'id';
    public const COL_CREATED = 'created_at';
    public const COL_UPDATED = 'updated_at';
    public const COL_DELETED = 'deleted_at';

    public const MSG        = 'message';
    public const ERR_MSG    = 'error_message';

    public const GOOGLE    = 'google';
    public const TOKEN    = 'token';

    public const OPERATOR_LIKE          = 'like';
    public const OPERATOR_EQUAL         = '=';
    public const OPERATOR_GREATER_EQUAL = '>=';
    public const OPERATOR_LESS_EQUAL    = '<=';
    public const OPERATOR_GREATER       = '>';
    public const OPERATOR_LESS_THAN     = '<';
    public const OPERATOR_DIFFERENT     = '<>';

    public const DATE_FORMAT_YMD = 'Y/m/d';

    public const ORDER_DESC = 'DESC';
    public const ORDER_ASC  = 'ASC';
}
