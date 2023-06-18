<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="title" content="Shoppies">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>{{ __('general.our-products-for-everyone') }} - Shoppies</title>

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('favicon/site.webmanifest') }}">

    <meta name="description" content="{{ __('general.about') }}">
    <meta name="keywords" content="{{ config('app.keywords') }}">

    <!-- Twitter Meta Data -->
    <meta name="twitter:app:name:iphone" content="{{ config('app.name', 'Shoppies')  }}">
    <meta name="twitter:app:id:iphone" content="{{ config('app.apple_id')  }}">
    <meta name="twitter:app:name:ipad" content="{{ config('app.name', 'Shoppies')  }}">
    <meta name="twitter:app:id:ipad" content="{{ config('app.apple_id') }}">
    <meta name="twitter:app:name:googleplay" content="{{ config('app.name')  }}">
    <meta name="twitter:app:id:googleplay" content="{{ config('app.google_play_id') }}">

    <!-- App Link Meta Data -->
    <meta property="al:ios:app_name" content="{{ config('app.name', 'Shoppies')  }}">
    <meta property="al:ios:app_store_id" content="{{ config('app.apple_id')  }}">
    <meta property="al:android:app_name" content="{{ config('app.name', 'Shoppies')  }}">
    <meta property="al:android:package" content="{{ config('app.android_bundle')  }}" />

    <!-- MINIFIED -->
    {!! \Artesaos\SEOTools\Facades\SEOTools::generate() !!}

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon.jpg') }}">
    @routes
</head>

<body>
    @inertia
    <script type="text/javascript">
        window.app_name = "{{ config('app.name') }}";
        window.default_locale = "{{ \Illuminate\Support\Facades\App::currentLocale() }}";
        window.fallback_locale = "{{ config('app.fallback_locale') }}";
    </script>

    <script src="{{ mix('/js/app.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/manifest.js') }}"></script>
</body>
<!-- Vendors scripts -->
<script src="{{ asset('vendors/jquery.min.js') }}" defer></script>
<script src="{{ asset('vendors/jquery-ui/jquery-ui.min.js') }}" defer></script>
<script src="{{ asset('vendors/bootstrap/bootstrap.bundle.js') }}" defer></script>
<script src="{{ asset('vendors/bootstrap-select/js/bootstrap-select.min.js') }}" defer></script>
<script src="{{ asset('vendors/slick/slick.min.js')}}" defer></script>
<script src="{{ asset('vendors/waypoints/jquery.waypoints.min.js') }}" defer></script>
<!-- <script src="{{ asset('vendors/counter/countUp.js') }}"></script> -->
<script src="{{ asset('vendors/magnific-popup/jquery.magnific-popup.min.js') }}" defer></script>
<script src="{{ asset('vendors/hc-sticky/hc-sticky.min.js') }}" defer></script>
<!-- <script src="{{ asset('vendors/jparallax/TweenMax.min.js') }}"></script> -->
<!-- <script src="{{ asset('vendors/mapbox-gl/mapbox-gl.js') }}"></script> -->
<!-- <script src="{{ asset('vendors/isotope/isotope.js') }}"></script> -->
<!-- Theme scripts -->
<script src="{{ asset('/js/theme.js') }}" defer></script>
<link href="https://fonts.googleapis.com/css2?family=Urbanist:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('vendors/fontawesome-pro-5/css/all.css') }}">
</html>