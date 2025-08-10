<!DOCTYPE html>
<html lang="en-us">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
    @yield('meta_tags')
    @php
        $settings = settings();
    @endphp
    <link rel="shortcut icon" href="/storage/images/site/{{ $settings->site_favicon ?? '' }}"" type="image/x-icon">
    <link rel="icon" href="/storage/images/site/{{ $settings->site_favicon ?? '' }}"" type="image/x-icon">
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
    <!-- navigation -->
    <header class="sticky-top bg-white border-bottom border-default">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-white">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img class="img-fluid" width="70px" src="/storage/images/site/{{ $settings->site_logo ?? '' }}"
                        alt="{{ $pageTitle ?? '' }}">
                </a>
                <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation">
                    <i class="ti-menu"></i>
                </button>

                <div class="collapse navbar-collapse text-center" id="navigation">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}"><i class="ti-home mr-1"></i>Home</a>
                        </li>
                        {!! navigations() !!}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('about_us') }}"><span
                                    class="icon-copy ti-info-alt mr-1"></span> About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('contact') }}"><i class="ti-email mr-1"></i>Contact</a>
                        </li>
                    </ul>

                    <!-- search -->
                    <div class="search px-4">
                        <button id="searchOpen" class="search-btn-top"><i class="ti-search"></i></button>
                        <div class="search-wrapper">
                            <form action="{{route('search_posts')}}" method="GET" class="h-100">
                                <input class="search-box pl-4" id="search-query" name="q" type="search"
                                    placeholder="Type to discover articles, guide &amp; tutorials... "
                                    value="{{ request('q') ?? '' }}">
                            </form>
                            <button id="searchClose" class="search-close"><i class="ti-close text-dark"></i></button>
                        </div>
                    </div>
                    <!-- /search -->

                    <!-- User Details + Dropdown -->
                    @auth
                        @php
                            $user = auth()->user();
                        @endphp
                        <div class="user-details">
                            <img src="{{ asset($user->picture) }}" class="img-fluid user-avatar" alt="User avatar">
                            <div class="user-dropdown">
                                <a href="{{ route('admin.dashboard') }}"><i class="ti-dashboard"></i>Dashboard</a>
                                <a href="{{ route('admin.profile') }}"><i class="ti-user"></i>Profile</a>
                                @if ($user->type == 'superAdmin')
                                    <a href="{{ route('admin.settings') }}"><i class="ti-settings"></i>Settings</a>
                                @endif
                                <form id="front-logout-form" method="POST" style="display: none"
                                    action="{{ route('admin.logout', ['source' => 'front']) }}">
                                    @csrf
                                </form>
                                <a href="javascript:;"
                                    onclick="event.preventDefault();document.getElementById('front-logout-form').submit();"><i
                                        class="ti-power-off"></i>Logout</a>
                            </div>
                        </div>
                    @endauth
                </div>
            </nav>
        </div>
    </header>
    <!-- /navigation -->

    <section class="section">
        <div class="container">
            @yield('content')
        </div>
    </section>

    <footer class="section-sm pb-0 border-top border-default">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-md-3 mb-4">
                    <a class="mb-4 d-block" href="{{ route('home') }}">
                        <img class="img-fluid" width="50px"
                            src="/storage/images/site/{{ $settings->site_logo ?? '' }}" alt="{{ $pageTitle ?? '' }}">
                    </a>
                    <p>{{ $settings->site_meta_description ?? '' }}</p>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <h6 class="mb-4">Quick Links</h6>
                    <ul class="list-unstyled footer-list">
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('about_us') }}">About</a></li>
                        <li><a href="{{ route('privacy_policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('term_conditions') }}">Terms Conditions</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-3 col-6 mb-4">
                    <h6 class="mb-4">Social Links</h6>
                    @php
                        $social_links = siteSocialLinks();
                    @endphp
                    <ul class="list-unstyled footer-list">
                        @if ($social_links->facebook_url)
                            <li><a target="_blank" href="{{ $social_links->facebook_url }}"> Facebook</a></li>
                        @endif
                        @if ($social_links->twitter_url)
                            <li><a target="_blank" href="{{ $social_links->twitter_url }}"> Twitter</a></li>
                        @endif
                        @if ($social_links->linkdin_url)
                            <li><a target="_blank" href="{{ $social_links->instagram_url }}"> Instagram</a></li>
                        @endif
                        @if ($social_links->linkdin_url)
                            <li><a target="_blank" href="{{ $social_links->linkdin_url }}">Linkedin</a></li>
                        @endif
                    </ul>
                </div>

                <div class="col-md-3 mb-4">
                    <h6 class="mb-4">Subscribe Newsletter</h6>
                    @livewire('news-letter-form')
                </div>
            </div>
            <div class="scroll-top">
                <a href="javascript:void(0);" id="scrollTop"><i class="ti-angle-up"></i></a>
            </div>
            <div class="text-center">
                <p class="content">&copy; {{ date('Y') }} - Design &amp; Develop By {{ config('app.name') }}</p>
            </div>
        </div>
    </footer>


    <script src="{{ asset('front/plugins/jQuery/jquery.min.js') }}"></script>
    <script src="{{ asset('front/plugins/bootstrap/bootstrap.min.js') }}" async></script>
    <script src="{{ asset('front/plugins/slick/slick.min.js') }}"></script>
    <script src="{{ asset('front/js/script.js') }}"></script>
    <script src="{{ asset('back/src/plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script>
        window.addEventListener('showToastr', function(event) {
            const detail = event.detail[0];

            $.toast({
                heading: detail.heading || 'Notification',
                text: detail.message || 'Something happened!',
                position: 'bottom-right',
                loaderBg: '#0EA5E9',
                hideAfter: 3500,
                stack: 6,
                showHideTransition: 'fade',
                icon: detail.type || 'info', // success | info | warning | error
            });
        });
    </script>
    <script>
        const userDetails = document.querySelector('.user-details');
        if (userDetails) {
            userDetails.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        }

        // Close Dropdown
        document.addEventListener('click', function(e) {
            const userDetails = document.querySelector('.user-details');
            if (userDetails) {
                if (!userDetails.contains(e.target)) {
                    userDetails.classList.remove('active');
                }
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
