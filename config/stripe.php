<?php

return [

    /*
    |--------------------------------------------------------------------------
    | PUBLIC/SECRET KEY OF STRIPE
    |--------------------------------------------------------------------------
    |
    | This is public and secret key for stripe test. Change it to live mode
    | when deploy.
    |
    */

    'public_key' => env('STRIPE_PUBLIC_KEY', false),
    'secret_key' => env('STRIPE_SECRET_KEY', false),

];
