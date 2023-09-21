<?php

namespace App\Services;

use App\Mail\SendMailRegister;
use App\Mail\SendMailResetPassword;
use App\Mail\InfoRegistration;
use App\Mail\PaymentApplyComplete;
use Mail;

class MailService
{
    public function sendMail(object $user, array $data = [])
    {
        Mail::to($user->email)->send(new SendMailRegister($user, $data));
    }

    public function sendMailResetPassword($email, $token)
    {
        $data['url'] = route('password.reset') . '?token=' . $token . '&email=' . $email;
        Mail::to($email)->send(new SendMailResetPassword($email, $data));
    }

    public function sendMailInformationRegister(object $user, array $data = [])
    {
        Mail::to($user->email)->send(new InfoRegistration($user, $data));
    }

    public function sendMailPaymentApplyComplete(object $user, array $data = [])
    {
        Mail::to($user->email)->send(new PaymentApplyComplete($user, $data));
    }
}
