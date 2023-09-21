<?php

namespace App\Constants;

class TeacherInformationConstants
{
    public const TBL_NAME = 'teacher_informations';

    public const COL_ID                     = 'id';
    public const COL_TEACHER_ID             = 'teacher_id';
    public const COL_EMAIL                  = 'email';
    public const COL_FIRST_NAME             = 'first_name';
    public const COL_LAST_NAME              = 'last_name';
    public const COL_BIRTHDAY               = 'birthday';
    public const COL_COUNTRY_CODE           = 'country_code';
    public const COL_COUNTRY_ID             = 'country_id';
    public const COL_CITY_ID                = 'city_id';
    public const COL_PHONE                  = 'phone';
    public const COL_HEADLINE               = 'headline';
    public const COL_ABOUT                  = 'about';
    public const COL_INTRODUCTION_VIDEO     = 'introduction_video';
    public const COL_BANK_NAME              = 'bank_name';
    public const COL_BRANCH_CODE            = 'branch_code';
    public const COL_ACCOUNT_TYPE           = 'account_type';
    public const COL_ACCOUNT_NUMBER         = 'account_number';
    public const COL_ACCOUNT_NAME           = 'account_name';
    public const COL_STRIPE_ACCOUNT_ID      = 'stripe_account_id';
    public const COL_STATUS                 = 'status';
    public const COL_CARD_IMAGE_FRONT       = 'card_image_front';
    public const COL_CARD_IMAGE_BACK        = 'card_image_back';
    public const COL_SCHOOL                 = 'school';
    public const COL_MAJOR                  = 'major';
    public const COL_MAJOR_SPECIALIZE       = 'major_specialize';
    public const COL_ADMISSION_DATE         = 'admission_date';
    public const COL_GRADUATION_DATE        = 'graduation_date';
    public const COL_ACADEMIC_CERTIFICATE   = 'academic_certificate';
    public const COL_JOB                    = 'job';
    public const COL_SALARY                 = 'salary';
    public const COL_PROFILE_IMAGE          = 'profile_image';
    public const COL_STEP                   = 'step';

    public const STORAGE_PROFILE_IMAGE      = 'public/profile_image';
    public const STORAGE_INTRODUCTION_VIDEO = 'public/introduction_video';
    public const STORAGE_CARD_IMAGE         = 'public/card_image';
    public const STORAGE_CERTIFICATE_IMAGE  = 'public/certificate_image';

    public const SCREEN_STEP_1              = 1;
    public const SCREEN_STEP_2              = 2;
    public const SCREEN_STEP_3              = 3;
    public const SCREEN_STEP_LIST           = 4;
    public const SCREEN_STEP_SUCCESS        = 5;
}
