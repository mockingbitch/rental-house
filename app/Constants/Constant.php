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
}
