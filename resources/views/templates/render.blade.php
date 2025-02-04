<!DOCTYPE html>
<html lang="{{ locale() }}">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta charset="utf-8">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Template Preview - {{ config('app.name') }}</title>

    <link rel="shortcut icon" href="{{ asset(mix("images/favicon/favicon.ico")) }}"/>

    <link rel="stylesheet" href="{{ asset(mix('/css/font-awesome.css')) }}"/>

    <!-- Fonts -->
    <link rel='stylesheet' href="{{ config('app.url_schema') }}://fonts.googleapis.com/css?family=Roboto:300,400,500,300italic"/>
    <link rel='stylesheet' href="{{ asset(mix('fonts/textur/textur.css')) }}"/>
    <link rel='stylesheet' href="{{ asset(mix('fonts/bangla/Bangla.css')) }}"/>
    <link rel='stylesheet' href="{{ asset(mix('fonts/simplified-arabic/simplified-arabic.css')) }}"/>

    <style>
        body {
            font-family: Roboto, 'Simplified Arabic', sans-serif;
        }

        {!! $css ?? '' !!}
    </style>
</head>

<body dir="{{ locale() === 'ar' ? 'rtl' : 'ltr' }}">

<div>
    {!! $html ?? '' !!}
</div>

@if (getenv('GOOGLE_ANALYTICS_ENABLED'))
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ getenv('GOOGLE_ANALYTICS_ID') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());
        gtag('config', '{{ getenv('GOOGLE_ANALYTICS_ID') }}');

        @auth
        gtag('set', {'user_id': '{{ Auth::id() }}'});
        @endauth
    </script>
@endif

</body>

</html>
