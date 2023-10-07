@component('mail::message')
# Rental House
<p>Thank you always. Thank you for registering your email address.</p>
<p>Please register for an account using the URL below.</p>
<p>This email is valid for 24 hours. (deadline : {{ $data['expires_in'] }} ) </p>
@component('mail::button', ['url' => route('user.information', ['token' => $data['remember_token']])])
Account registration URL
@endcomponent
<p>========== </p>
<p>*This email is automatically delivered. Also, please note that we cannot respond to your inquiry even if you reply directly, as it is for sending only.</p>
<p> ==========</p>

{{ config('app.name') }}
@endcomponent