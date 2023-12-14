@component('mail::message')
<p>{{ $data['first_name'] }}</p>
<p>Thank you always.</p>
<p>Thank you for registering your account.</p>
<p>You can check and change your account registration details from the URL below.</p>
@component('mail::button', ['url' => $data['url']])
Account registration URL
@endcomponent
<p>========== </p>
<p>*This email is automatically delivered. Also, please note that we cannot respond to your inquiry even if you reply directly, as it is for sending only.</p>
<p> ==========</p>

{{ config('app.name') }}
@endcomponent