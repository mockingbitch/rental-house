<?php

namespace App\Constants;

use App\Constants\LessonConstants;

class StripeConstants
{
    public const PAYMENT_INTENT_SUCCEEDED = 'succeeded';
    public const PAYMENT_INTENT_PROCESSING = 'processing';

    public const PAYMENT_CURRENCY = [
        LessonConstants::CURRENCY_EN => [
            'currency' => 'usd',
            'multiplier' => 100,
            'symbol' => '$',
        ],

        LessonConstants::CURRENCY_JP => [
            'currency' => 'jpy',
            'multiplier' => 1,
            'symbol' => '円',
        ],

        LessonConstants::CURRENCY_VIE => [
            'currency' => 'vnd',
            'multiplier' => 1,
            'symbol' => '₫',
        ],
    ];

    //list mcc: https://stripe.com/docs/connect/setting-mcc
    public const MCC = [
        'colleges_universities' => 8220,
        'digital_goods_media' => 5815,
        'educational_services' => 8299,
    ];

    public const COUNTRIES = [
        '1' => [
            'abbr_name' => 'JP',
        ],
        '2' => [
            'abbr_name' => 'VN',
        ],
    ];
}