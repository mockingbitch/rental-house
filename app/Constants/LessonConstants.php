<?php

namespace App\Constants;

class LessonConstants
{
    public const TBL_NAME = 'lessons';

    public const LANG_JP    = 1;
    public const LANG_EN    = 2;
    public const LANG_VIE   = 3;

    public const STYLE_INTERVIEW   = 1;
    public const STYLE_PERSONAL    = 2;

    public const CURRENCY_EN   = 1;
    public const CURRENCY_JP   = 2;
    public const CURRENCY_VIE  = 3;

    public const STATUS_INACTIVE    = '0';
    public const STATUS_ACTIVE      = '1';
    public const STATUS_DRAFT       = '2';
    public const STATUS_PENDING     = '3';
    public const STATUS_SENDBACK    = '4';
    public const STATUS_RECALL      = '5';
    public const STATUS_SUSPEND     = '6';

    public const ACTION_SAVE_DRAFT    = 'save_draft';
    public const ACTION_NEXT_STEP     = 'next_step';

    public const COL_ID               = 'id';
    public const COL_TITLE            = 'title';
    public const COL_TEACHER_ID       = 'teacher_id';
    public const COL_PRICE            = 'price';
    public const COL_DESCRIPTION      = 'description';
    public const COL_CATEGORY_ID      = 'category_id';
    public const COL_TARGET_AGE_FROM  = 'target_age_from';
    public const COL_TARGET_AGE_TO    = 'target_age_to';
    public const COL_MIN_LEARNER      = 'min_learner';
    public const COL_MAX_LEARNER      = 'max_learner';
    public const COL_NUMBER_OF_MEETS  = 'number_of_meets';
    public const COL_LESSON_HOUR      = 'lesson_hour';
    public const COL_LESSON_MINUTE    = 'lesson_minute';
    public const COL_TOTAL_OF_MEETS   = 'total_of_meets';
    public const COL_LANGUAGE         = 'language';
    public const COL_STYLE            = 'style';
    public const COL_CURRENCY         = 'currency';
    public const COL_COVER_IMAGE      = 'cover_image';
    public const COL_SHORT_VIDEO_FOR_PARENT   = 'short_video_for_parent';
    public const COL_SHORT_VIDEO_FOR_LEARNER  = 'short_video_for_learner';
    public const COL_TEMPLATE         = 'template';
    public const COL_NOTE             = 'note';
    public const COL_STATUS           = 'status';
    public const COL_START_DATE       = 'start_date';
    public const COL_END_DATE         = 'end_date';
    public const COL_VIEW             = 'view';
    public const STORAGE_COVER_IMAGE  = 'public/cover_image';
    public const STORAGE_FOR_PARENT   = 'public/short_video_for_parent';
    public const STORAGE_FOR_LEARNER  = 'public/short_video_for_learner';
}
