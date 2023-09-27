<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Rental House</title>
    <meta name="title" content="" />
    <meta name="description" content="" />
    @csrf

    <!-- Scripts -->
    @routes
    @vite('resources/js/bootstrap.js')
    @vite('resources/js/app.js') @inertiaHead
    @inertiaHead
    {{-- <script src="https://js.stripe.com/v3/"></script> --}}
    <link rel="stylesheet" href="{{ asset('/css/fontawesome.min.css') }}"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('scss/style.css.map') }}">
    <link rel="stylesheet" href="{{ asset('scss/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
</head>

{{-- <body class=""> --}}
@inertia
{{-- </body> --}}
</html>
