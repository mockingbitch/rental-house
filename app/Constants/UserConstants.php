<?php

namespace App\Constants;

class UserConstants
{
    public const TBL_NAME = 'users';

    public const ROLE_ADMIN     = 1;
    public const ROLE_TEACHER   = 2;
    public const ROLE_PARENT    = 3;
    public const VENDOR_EMAIL   = 1;
    public const VENDOR_GOOGLE  = 2;

    // verify teacher status
    public const COMMON_USER = 0;
    public const REQUEST_VERIFYING = 1;
    public const REQUEST_VERIFIED = 2;
    public const REQUEST_DENIED = 3;

    // add information status
    public const INFORMATION_COMPLETED = '1';
    public const INFORMATION_INCOMPLETE = '0';

    public const COL_ID                         = 'id';
    public const COL_NICK_NAME                  = 'nick_name';
    public const COL_FIRST_NAME                 = 'first_name';
    public const COL_LAST_NAME                  = 'last_name';
    public const COL_FIRST_NAME_KANA            = 'first_name_kana';
    public const COL_LAST_NAME_KANA             = 'last_name_kana';
    public const COL_EMAIL                      = 'email';
    public const COL_PASSWORD                   = 'password';
    public const COL_PASSWORD_CONFIRMATION      = 'password_confirmation';
    public const COL_DESCRIPTION                = 'description';
    public const COL_AVATAR                     = 'avatar';
    public const COL_ROLE                       = 'role';
    public const COL_VERIFY_TEACHER             = 'verify_teacher';
    public const COL_BIRTHDAY                   = 'birthday';
    public const COL_COUNTRY_ID                 = 'country_id';
    public const COL_CITY_ID                    = 'city_id';
    public const COL_STATUS                     = 'status';
    public const COL_VENDOR                     = 'vendor';
    public const COL_REGION                     = 'region';
    public const COL_REMEMBER_TOKEN             = 'remember_token';
    public const COL_EMAIL_VERIFIED_AT          = 'email_verified_at';

    public const G_DATA_NAME = "name";
    public const G_DATA_EMAIL = "email";
    public const G_DATA_AVATAR = "avatar";
    public const G_DATA_GIVEN_NAME = "given_name";
    public const G_DATA_FAMILY_NAME = "family_name";
    public const G_DATA_PICTURE = "picture";
    public const G_DATA_LOCALE = "locale";
}
