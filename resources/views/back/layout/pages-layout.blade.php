<!DOCTYPE html>
<html>

<head>
    <!-- Basic Page Info -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('pageTitle')</title>

    <!-- Site favicon -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('storage/images/site/' . (settings()->site_favicon ?? 'default-favicon.png')) }}">

    <!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="robots" content="noindex, follow">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('back/vendors/styles/core.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('back/vendors/styles/icon-font.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('back/vendors/styles/style.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('back/src/plugins/jquery-ui-1.14.1/jquery-ui.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('back/src/plugins/jquery-ui-1.14.1/jquery-ui.structure.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('back/src/plugins/jquery-ui-1.14.1/jquery-ui.theme.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('back/src/plugins/sweetalert2/sweetalert2.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('back/src/plugins/jquery-toast-plugin/jquery.toast.min.css') }}" />
    @kropifyStyles
    @stack('stylesheets')
</head>

<body>
    <div class="pre-loader">
        <div class="pre-loader-box">
            <div class="loader-logo">
                <img src="{{ settings()->site_logo ? asset('storage/images/site/' . settings()->site_logo) : asset('default-logo.png') }}"
                    alt="Loader Logo" class="light-logo img-fluid" width="100px" />
            </div>
            <div class="loader-progress" id="progress_div">
                <div class="bar" id="bar1"></div>
            </div>
            <div class="percent" id="percent1">0%</div>
            <div class="loading-text">Loading...</div>
        </div>
    </div>

    <div class="header">
        <div class="header-left">
            <div class="menu-icon bi bi-list"></div>
            <div class="search-toggle-icon bi bi-search" data-toggle="header_search"></div>
            <div class="header-search">
                <form>
                    <div class="form-group mb-0">
                        <i class="dw dw-search2 search-icon"></i>
                        <input type="text" class="form-control form-control-sm search-input"
                            placeholder="Search Here" />
                        <div class="dropdown">
                            <a class="dropdown-toggle no-arrow" href="#" role="button" data-toggle="dropdown">
                                <i class="ion-arrow-down-c"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">From</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">To</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-md-2 col-form-label">Subject</label>
                                    <div class="col-sm-12 col-md-10">
                                        <input class="form-control form-control-sm form-control-line" type="text" />
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-primary">Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="header-right">
            @livewire('admin.top-user-info')
        </div>
    </div>

    <div class="right-sidebar">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-blue">
                Layout Settings
                <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>
        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10">Header Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
                <div class="sidebar-radio-group pb-10 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon"
                            class="custom-control-input" value="icon-style-1" checked="" />
                        <label class="custom-control-label" for="sidebaricon-1"><i
                                class="fa fa-angle-down"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon"
                            class="custom-control-input" value="icon-style-2" />
                        <label class="custom-control-label" for="sidebaricon-2"><i
                                class="ion-plus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon"
                            class="custom-control-input" value="icon-style-3" />
                        <label class="custom-control-label" for="sidebaricon-3"><i
                                class="fa fa-angle-double-right"></i></label>
                    </div>
                </div>

                <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
                <div class="sidebar-radio-group pb-30 mb-10">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-1" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-1" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-1"><i
                                class="ion-minus-round"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-2" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-2" />
                        <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
                                aria-hidden="true"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-3" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-3" />
                        <label class="custom-control-label" for="sidebariconlist-3"><i
                                class="dw dw-check"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-4" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-4" checked="" />
                        <label class="custom-control-label" for="sidebariconlist-4"><i
                                class="icon-copy dw dw-next-2"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-5" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-5" />
                        <label class="custom-control-label" for="sidebariconlist-5"><i
                                class="dw dw-fast-forward-1"></i></label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="sidebariconlist-6" name="menu-list-icon"
                            class="custom-control-input" value="icon-list-style-6" />
                        <label class="custom-control-label" for="sidebariconlist-6"><i
                                class="dw dw-next"></i></label>
                    </div>
                </div>

                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">
                        Reset Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="left-side-bar">
        <div class="brand-logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ settings()->site_logo ? asset('storage/images/site/' . settings()->site_logo) : asset('default-logo.png') }}"
                    alt="Site Logo" class="dark-logo img-fluid brand_logo" style="width: 90px; height: 55px;" />
            </a>
            <div class="close-sidebar" data-toggle="left-sidebar-close">
                <i class="ion-close-round"></i>
            </div>
        </div>
        <div class="menu-block customscroll">
            <div class="sidebar-menu">
                <ul id="accordion-menu">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="dropdown-toggle no-arrow {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                            <span class="micon fa fa-home"></span>
                            <span class="mtext">Home</span>
                        </a>
                    </li>
                    @if (auth()->user()->type == 'superAdmin')
                        <li>
                            <a href="{{ route('admin.categories') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.categories') ? 'active' : '' }}">
                                <span class="micon fa fa-th-list"></span>
                                <span class="mtext">Categories</span>
                            </a>
                        </li>
                    @endif
                    <li class="dropdown">
                        <a href="javascript:;"
                            class="dropdown-toggle {{ Route::is('admin.add_post') || Route::is('admin.posts') || Route::is('admin.post') ? 'active' : '' }}">
                            <span class="micon bi bi-archive"></span>
                            <span class="mtext">Posts</span>
                        </a>
                        <ul class="submenu">
                            <li><a href="{{ route('admin.add_post') }}"
                                    class="{{ Route::is('admin.add_post') ? 'active' : '' }}">New</a></li>
                            <li><a href="{{ route('admin.posts') }}"
                                    class="{{ Route::is('admin.posts') ? 'active' : '' }}">Posts</a></li>
                        </ul>
                    </li>
                    @if (auth()->user()->type == 'superAdmin')
                        <li>
                            <a href="{{ route('admin.advertisements') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.advertisements') ? 'active' : '' }}">
                                <span class="micon fa fa-bullhorn"></span>
                                <span class="mtext">Advertisements</span>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->type == 'superAdmin')
                        <li>
                            <a href="{{ route('admin.news_subscriber_list') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.news_subscriber_list') ? 'active' : '' }}">
                                <span class="micon fa fa-list"></span>
                                <span class="mtext">Subscriber List</span>
                            </a>
                        </li>
                    @endif
                    {{-- @if (auth()->user()->type == 'superAdmin')
                        <li class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon fa fa-shopping-bag"></span>
                                <span class="mtext">Shop</span>
                            </a>
                            <ul class="submenu">
                                <li><a href="">New Product</a></li>
                                <li><a href="">All Products</a></li>
                            </ul>
                        </li>
                    @endif --}}
                    {{-- <li>
                        <a href="invoice.html" class="dropdown-toggle no-arrow">
                            <span class="micon bi bi-receipt-cutoff"></span>
                            <span class="mtext">Invoice</span>
                        </a>
                    </li> --}}
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <div class="sidebar-small-cap">Settings</div>
                    </li>
                    <li>
                        <a href="{{ route('admin.profile') }}"
                            class="dropdown-toggle no-arrow {{ Route::is('admin.profile') ? 'active' : '' }}">
                            <span class="micon fa fa-user-circle"></span>
                            <span class="mtext">Profile</span>
                        </a>
                    </li>
                    @if (auth()->user()->type == 'superAdmin')
                        <li>
                            <a href="{{ route('admin.settings') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.settings') ? 'active' : '' }}">
                                <span class="micon fa fa-cogs"></span>
                                <span class="mtext">General</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.slider') }}"
                                class="dropdown-toggle no-arrow {{ Route::is('admin.slider') ? 'active' : '' }}">
                                <span class="micon fa fa-cogs"></span>
                                <span class="mtext">Manage Slider</span>
                            </a>
                        </li>
                    @endif
                </ul>

            </div>
        </div>
    </div>
    <div class="mobile-menu-overlay"></div>

    <div class="main-container">
        <div class="pd-ltr-20 xs-pd-20-10">
            <div class="min-height-200px">
                <div class="">
                    @yield('content')
                </div>
            </div>
            <div class="footer-wrap pd-20 mb-20 card-box">
                &copy; {{ date('Y') }} - Design &amp; Develop By {{ config('app.name') }}
            </div>
        </div>
    </div>
    <!-- welcome modal end -->
    <!-- js -->
    <script src="{{ asset('back/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('back/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('back/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('back/vendors/scripts/layout-settings.js') }}"></script>
    <script src="{{ asset('back/src/plugins/jquery-toast-plugin/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('back/src/plugins/jquery-ui-1.14.1/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('back/src/plugins/jquery-validation/jquery.validate.js') }}"></script>
    <script src="{{ asset('back/src/plugins/jquery-form/jquery.form.min.js') }}"></script>
    <script src="{{ asset('back/src/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('back/src/custom/Notifications.js') }}"></script>
    @kropifyScripts
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

    @stack('scripts')
</body>

</html>
