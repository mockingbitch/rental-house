<?php
namespace App\Constants;

class Constant
{
    const ERR_CODE_OK           = 0;
    const ERR_CODE_ERROR        = 1;
    const ERR_CODE_EXCEPTION    = 2;
    const ERR_CAUGHT_ERROR      = 400;
    const ERR_CODE_NOT_EXIST    = 404;

    const MSG_CAUGHT_ERROR      = 'Exception caught';
    const MSG_OK                = 'OK';
    const MSG_NOT_EXIST         = ' not found';
    const MSG_ERROR             = 'Error';
    const MSG_EXCEPTION         = 'Exception';
    const MSG_INVALID_REQUEST   = 'Invalid data send';
    const MSG_SETUP_SUCCESS     = 'Setup successful';
    const MSG_CREATE_FAILED     = 'Create failed';
    const MSG_ADDRESS_NOT_FOUND = 'Address not found';
    const MSG_UPDATE_FAILED     = 'Update failed';

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
