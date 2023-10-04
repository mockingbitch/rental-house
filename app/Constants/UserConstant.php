<?php

namespace App\Constants;

class UserConstant
{
    public const MSG_NOT_FOUND = 'User not found';
    public const TBL_NAME = 'users';

    public const STORAGE_LINK_AVATAR = 'public/avatar';

    public const ROLE_SUP_ADMIN = 0;
    public const ROLE_ADMIN     = 1;
    public const ROLE_LESSOR    = 2;
    public const ROLE_LESSEE    = 3;
    public const VENDOR_EMAIL   = 1;
    public const VENDOR_GOOGLE  = 2;

    public const COL_ID                         = 'id';
    public const COL_FIRST_NAME                 = 'first_name';
    public const COL_LAST_NAME                  = 'last_name';
    public const COL_EMAIL                      = 'email';
    public const COL_PASSWORD                   = 'password';
    public const COL_PASSWORD_CONFIRMATION      = 'password_confirmation';
    public const COL_DESCRIPTION                = 'description';
    public const COL_AVATAR                     = 'avatar';
    public const COL_ROLE                       = 'role';
    public const COL_BIRTHDAY                   = 'birthday';
    public const COL_COUNTRY_ID                 = 'country_id';
    public const COL_CITY_ID                    = 'city_id';
    public const COL_STATUS                     = 'status';
    public const COL_VENDOR                     = 'vendor';
    public const COL_REGION                     = 'region';
    public const COL_REMEMBER_TOKEN             = 'remember_token';
    public const COL_EMAIL_VERIFIED_AT          = 'email_verified_at';

    public const G_DATA_NAME        = 'name';
    public const G_DATA_EMAIL       = 'email';
    public const G_DATA_AVATAR      = 'avatar';
    public const G_DATA_GIVEN_NAME  = 'given_name';
    public const G_DATA_FAMILY_NAME = 'family_name';
    public const G_DATA_PICTURE     = 'picture';
    public const G_DATA_LOCALE      = 'locale';
}