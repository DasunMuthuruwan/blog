<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    @yield('meta_tags')
    @php
        $settings = settings();
        $siteFavicon = $settings->site_favicon ?? '';
    @endphp
    <link rel="shortcut icon" href='{{ $siteFavicon ? asset("storage/images/site/{$siteFavicon}") : "" }}' type="image/x-icon">
    <link rel="icon" href='{{ $siteFavicon ? asset("storage/images/site/{$siteFavicon}") : "" }}'>
    <link rel="stylesheet" href="{{ asset('front/plugins/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/plugins/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('front/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('front/css/style.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('back/src/plugins/jquery-toast-plugin/jquery.toast.min.css') }}" />
    @stack('stylesheets')
</head>

<body>
    <section class="section">
        <div class="container">
            @yield('content')
        </div>
    </section>
</body>

</html>
