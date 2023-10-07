@component('mail::message')
# Rental House
<p>Thank you always. Thank you for setting up your information.</p>
<p>Please visit the dashboard using the URL below.</p>
@component('mail::button', ['url' => route('admin.dashboard')])
Dashboard
@endcomponent
<p>========== </p>
<p>*This email is automatically delivered. Also, please note that we cannot respond to your inquiry even if you reply directly, as it is for sending only.</p>
<p> ==========</p>

{{ config('app.name') }}
@endcomponent
