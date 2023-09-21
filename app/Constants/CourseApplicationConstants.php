<?php

namespace App\Constants;

class CourseApplicationConstants
{
    public const TBL_NAME = 'course_applications';

    public const COL_ID = 'id';
    public const COL_COURSE_ID = 'course_id';
    public const COL_USER_ID = 'user_id';
    public const COL_LEARNER_QUESTION = 'learner_question';
    public const COL_PAYMENT_INTENT_ID = 'payment_intent_id';
    public const COL_STATUS = 'status';
    public const COL_CANCEL_REASON = 'cancel_reason';

    public const STATUS_UNCOMPLETE = '0';
    public const STATUS_COMPLETE = '1';
    public const STATUS_CANCEL = '2';
}
