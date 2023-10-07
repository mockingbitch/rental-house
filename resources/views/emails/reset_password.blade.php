<x-mail::message>
# Rental House

Reset password notification

<x-mail::button :url="''" >
<a href="{{ $data['url'] }}">Click here to reset your password</a>

</x-mail::button>

{{ config('app.name') }}
</x-mail::message>