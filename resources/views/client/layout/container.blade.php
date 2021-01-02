@php
    $logo = optional(getSettings('logo'))->value;
@endphp
    <!DOCTYPE html>
<html lang="{{app()->getlocale()}}" dir="{{direction()}}">

<!-- begin::Head -->
<head>

    <meta charset="utf-8"/>
    <title>{{ isset($title) ? $title. " | ":''  }}{{ t('Dashboard') }}</title>
    <meta name="description" content="{{ t('Dashboard') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Poppins:300,400,500,600,700", "Roboto:300,400,500,600,700"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!--end::Fonts -->


    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="{{ asset('assets/css/demo6/style.bundle.'.direction('.').'css') }}" rel="stylesheet" type="text/css"/>
    <!--end::Global Theme Styles -->
    <link href="{{ asset('assets/css/demo6/pages/general/invoices/invoice-1.'.direction('.').'css') }}" rel="stylesheet"
          type="text/css"/>

    <!--begin:: Global Mandatory Vendors -->
    <link href="{{ asset('assets/vendors/general/perfect-scrollbar/css/perfect-scrollbar.'.direction('.').'css') }}"
          rel="stylesheet" type="text/css"/>

    <!--end:: Global Mandatory Vendors -->
@yield('b_style')

<!--begin:: Global Optional Vendors -->
    <link href="{{ asset('assets/vendors/general/tether/dist/css/tether.'.direction('.').'css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/vendors/general/animate.css/animate.'.direction('.').'css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/vendors/general/toastr/build/toastr.'.direction('.').'css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset('assets/vendors/general/sweetalert2/dist/sweetalert2.'.direction('.').'css') }}"
          rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/custom/vendors/line-awesome/css/line-awesome.css') }}" rel="stylesheet"
          type="text/css"/>
    <link href="{{ asset("assets/vendors/custom/vendors/flaticon/flaticon.css") }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset("assets/vendors/custom/vendors/flaticon2/flaticon.css") }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('assets/vendors/general/@fortawesome/fontawesome-free/css/all.min.'.direction('.').'css') }}"
          rel="stylesheet" type="text/css"/>

    <!--end:: Global Optional Vendors -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
@yield('style')
<!--end::Layout Skins -->
    @if(isset($logo))
        <link rel="shortcut icon" href="{{ asset($logo) }}"/>
    @endif
</head>

<!-- end::Head -->

<!-- begin::Body -->
<body
    class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-aside--minimize kt-page--loading">

<!-- begin:: Page -->

<!-- begin:: Header Mobile -->
<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
    <div class="kt-header-mobile__logo">
        <a href="{{ url("/client/home") }}">
            {{--            <img alt="Logo" src="{{ asset("assets/media/logos/logo.svg") }}" style="width: 6%"/>--}}
            <h3>App Logo</h3>
        </a>
    </div>
    <div class="kt-header-mobile__toolbar">
        <div class="kt-header-mobile__toolbar-toggler kt-header-mobile__toolbar-toggler--left"
             id="kt_aside_mobile_toggler">
            <span></span>
        </div>
        <div class="kt-header-mobile__toolbar-toggler" id="kt_header_mobile_toggler"><span></span></div>
        <div class="kt-header-mobile__toolbar-topbar-toggler" id="kt_header_mobile_topbar_toggler"><i
                class="flaticon-more"></i></div>
    </div>
</div>

<!-- end:: Header Mobile -->
<div class="kt-grid kt-grid--hor kt-grid--root">
    <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">

        <!-- begin:: Aside -->
        <button class="kt-aside-close " id="kt_aside_close_btn"><i class="la la-close"></i></button>
        <div class="kt-aside  kt-aside--fixed  kt-grid__item kt-grid kt-grid--desktop kt-grid--hor-desktop"
             id="kt_aside">

            <!-- begin:: Aside Menu -->
            <div class="kt-aside-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_aside_menu_wrapper">
                <div id="kt_aside_menu" class="kt-aside-menu " data-ktmenu-vertical="1" data-ktmenu-scroll="1"
                     data-ktmenu-dropdown-timeout="500">
                    <ul class="kt-menu__nav ">
                        <li class="kt-menu__item  @if(Request::is('client/home*') ) kt-menu__item--active @endif"
                            aria-haspopup="true">
                            <a href="{{ route('client.home') }}" class="kt-menu__link ">
                                <i class="kt-menu__link-icon flaticon2-protection"></i>
                                <span class="kt-menu__link-text">{{ t('Dashboard') }}</span>
                            </a>
                        </li>


                        @can('items')
                            <li class="kt-menu__item  @if(Request::is('client/items*') ) kt-menu__item--active @endif"
                                aria-haspopup="true">
                                <a href="{{route('client.items.index')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-icon la la-forumbee"></i>
                                    <span class="kt-menu__link-text">{{ t('Items') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('clients')
                            <li class="kt-menu__item  @if(Request::is('client/clients*') ) kt-menu__item--active @endif"
                                aria-haspopup="true">
                                <a href="{{route('client.clients.index')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-icon flaticon2-group"></i>
                                    <span class="kt-menu__link-text">{{ t('clients') }}</span>
                                </a>
                            </li>
                        @endcan


                        @can('users')
                            <li class="kt-menu__item  @if(Request::is('client/users*') ) kt-menu__item--active @endif"
                                aria-haspopup="true">
                                <a href="{{route('client.users.index')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-icon fa fa-child"></i>
                                    <span class="kt-menu__link-text">{{ t('Users') }}</span>
                                </a>
                            </li>
                        @endcan

                        @can('bills')
                            <li class="kt-menu__item  @if(Request::is('client/bills*') ) kt-menu__item--active @endif"
                                aria-haspopup="true">
                                <a href="{{route('client.bills.index')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-icon flaticon-list"></i>
                                    <span class="kt-menu__link-text">{{ t('Bills') }}</span>
                                </a>
                            </li>
                        @endcan


                        @can('expenses')
                            <li class="kt-menu__item  @if(Request::is('client/expenses*') ) kt-menu__item--active @endif"
                                aria-haspopup="true">
                                <a href="{{route('client.expenses.index')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-icon la la-dollar"></i>
                                    <span class="kt-menu__link-text">{{ t('Expenses') }}</span>
                                </a>
                            </li>
                        @endcan

{{--                        @can('cds')--}}
{{--                            <li class="kt-menu__item  @if(Request::is('client/cds*') ) kt-menu__item--active @endif"--}}
{{--                                aria-haspopup="true">--}}
{{--                                <a href="{{route('client.cds.index')}}" class="kt-menu__link ">--}}
{{--                                    <i class="kt-menu__link-icon la la-repeat"></i>--}}
{{--                                    <span class="kt-menu__link-text">{{ t('Creditor Debtor') }}</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        @endcan--}}

                        @can('payments')
                            <li class="kt-menu__item  @if(Request::is('client/payments*') ) kt-menu__item--active @endif"
                                aria-haspopup="true">
                                <a href="{{route('client.payments.index')}}" class="kt-menu__link ">
                                    <i class="kt-menu__link-icon la la-dollar"></i>
                                    <span class="kt-menu__link-text">{{ t('Payments') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </div>

            <!-- end:: Aside Menu -->
        </div>

        <!-- end:: Aside -->
        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" id="kt_wrapper">

            <!-- begin:: Header -->
            <div id="kt_header" class="kt-header kt-grid kt-grid--ver  kt-header--fixed ">

                <!-- begin:: Aside -->
                <div class="kt-header__brand kt-grid__item  " id="kt_header_brand">
                    <div class="kt-header__brand-logo">
                        <a href="{{ url("/client/home") }}">
                            @if(isset($logo))
                                <img alt="Logo" src="{{ asset($logo) }}" style="width: 100%"/>
                            @else
                                <h4 class="text-center">App logo</h4>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- end:: Aside -->

                <!-- begin:: Title -->
                <div class="dd" style="margin-right: 20px;padding: 20px 0;">
                    <h3 class="kt-header_title kt-grid_item">لوحدة النظام</h3>
                    @if(isset(cached()->name))
                        <p>{{ cached()->name }}</p>
                    @endif
                </div>

                <!-- end:: Title -->

                <!-- begin: Header Menu -->
                <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i
                        class="la la-close"></i></button>
                <div class="kt-header-menu-wrapper kt-grid__item kt-grid__item--fluid" id="kt_header_menu_wrapper">
                    <div id="kt_header_menu"
                         class="kt-header-menu kt-header-menu-mobile  kt-header-menu--layout-default ">
                        <ul class="kt-menu__nav ">


                        </ul>
                    </div>
                </div>
                <!-- end: Header Menu -->

                <!-- begin:: Header Topbar -->
                <div class="kt-header__topbar">

                    <!--begin: User bar -->
                    <div class="kt-header__topbar-item kt-header__topbar-item--user">
                        <div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="10px,0px">
                            <span class="kt-hidden kt-header__topbar-welcome"></span>
                            <span class="kt-hidden kt-header__topbar-username">{{ Auth::user()->name }}</span>
                            <span class="kt-header__topbar-icon kt-hidden-"><i
                                    class="flaticon2-user-outline-symbol"></i></span>
                        </div>
                        <div
                            class="dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-xl">

                            <!--begin: Head -->
                            <div class="kt-user-card kt-user-card--skin-dark kt-notification-item-padding-x"
                                 style="background: linear-gradient(to right,#db1515,#ec5252)">
                                <div class="kt-user-card__avatar">

                                    {{--                                    <span class="kt-badge kt-badge--lg kt-badge--rounded kt-badge--bold kt-font-success">{{ substr(Auth::user()->name,0,1) }}</span>--}}
                                </div>
                                <div class="kt-user-card__name">
                                    {{ Auth::user()->name }}
                                </div>

                            </div>
                            <!--end: Head -->
                            <!--begin: Navigation -->
                            <div class="kt-notification">
                                <a href="{{route('client.profile.show')}}" class="kt-notification__item">
                                    <div class="kt-notification__item-icon">
                                        <i class="flaticon2-calendar-3 kt-font-success"></i>
                                    </div>
                                    <div class="kt-notification__item-details">
                                        <div class="kt-notification__item-title kt-font-bold">
                                            {{ t('profile') }}
                                        </div>
                                        <div class="kt-notification__item-time">
                                            {{ t('profile Settings') }}
                                        </div>
                                    </div>
                                </a>
                                <div class="kt-notification__custom kt-space-between">
                                    <form id="logout-form" action="{{ url("/client/logout") }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <a href="{{ url("/client/logout") }}" onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();"
                                       class="btn btn-label btn-label-brand btn-sm btn-bold">{{ t('Logout') }}</a>
                                </div>
                            </div>

                            <!--end: Navigation -->
                        </div>
                    </div>

                    <!--end: User bar -->
                </div>

                <!-- end:: Header Topbar -->
            </div>

            <!-- end:: Header -->
            @stack('search')
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor">

                <!-- begin:: Content -->

                <!-- begin:: Content -->
                <div class="kt-content  kt-grid__item kt-grid__item--fluid" id="kt_content">
                    @if(!Request::is('client/home'))
                        <div>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ url('/client/home') }}">{{ t('Home') }}</a>
                                </li>
                                @stack('breadcrumb')
                            </ul>
                        </div>
                    @endif
                <!--Begin::Dashboard 6-->
                    {{--
                    @if(Session::has('message'))
                        <div class="alert alert-{{ Session::get('m-class') }} role="alert">
                            <div class="alert-text">{{ Session::get('message') }}</div>
                            <div class="alert-close">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true"><i class="la la-close"></i></span>
                                </button>
                            </div>
                        </div>
                    @endif

                    --}}
                    @if (count($errors) > 0)
                        <div class="alert alert-warning">
                            <ul style="width: 100%;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield("content")
                </div>

                <!-- end:: Content -->

                <!-- end:: Content -->
            </div>

            <!-- begin:: Footer -->
            <div class="kt-footer kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
                <div class="kt-footer__copyright">
                    {{ date('Y') }}&nbsp;&copy;&nbsp;<a href="http://soe.com.sa" target="_blank" class="kt-link"> </a>
                </div>
                <div class="kt-footer__menu">
                </div>
            </div>

            <!-- end:: Footer -->
        </div>
    </div>
</div>

<!-- end:: Page -->


<!-- begin::Scrolltop -->
<div id="kt_scrolltop" class="kt-scrolltop">
    <i class="fa fa-arrow-up"></i>
</div>

<!-- end::Scrolltop -->


<!-- begin::Global Config(global config for global JS sciprts) -->

<!-- end::Global Config -->
<script>
    var KTAppOptions = {
        "colors": {
            "state": {
                "brand": "#22b9ff",
                "light": "#ffffff",
                "dark": "#282a3c",
                "primary": "#5867dd",
                "success": "#34bfa3",
                "info": "#36a3f7",
                "warning": "#ffb822",
                "danger": "#fd3995"
            },
            "base": {
                "label": ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"],
                "shape": ["#f0f3ff", "#d9dffa", "#afb4d4", "#000000"]
            }
        }
    };
</script>
<!--begin:: Global Mandatory Vendors -->
<script src="{{ asset("assets/vendors/general/jquery/dist/jquery.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/popper.js/dist/umd/popper.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/bootstrap/dist/js/bootstrap.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/js-cookie/src/js.cookie.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/moment/min/moment.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/sticky-js/dist/sticky.min.js") }}" type="text/javascript"></script>
<script src="{{ asset("assets/vendors/general/perfect-scrollbar/dist/perfect-scrollbar.js") }}"
        type="text/javascript"></script>


<!--end:: Global Mandatory Vendors -->
@yield('b_script')
<!--begin:: Global Optional Vendors -->
<script src="{{ asset("assets/vendors/general/toastr/build/toastr.min.js") }}" type="text/javascript"></script>

<!--end:: Global Optional Vendors -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="{{ asset("assets/js/demo6/scripts.bundle.js") }}" type="text/javascript"></script>
{{--<script src="https://js.pusher.com/7.0/pusher.min.js"></script>--}}


<!--end::Global Theme Bundle -->

<!--begin::Page Vendors(used by this page) -->

<!--end::Page Vendors -->

<!--begin::Page Scripts(used by this page) -->

<!--end::Page Scripts -->
@yield('script')
<script type="text/javascript">
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "100",
        "hideDuration": "2000",
        "timeOut": "10000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    @if(Session::has('message'))
    toastr.{{Session::get('m-class') ? Session::get('m-class'):'success'}}("{{Session::get('message')}}");

    @endif
</script>
</body>

<!-- end::Body -->
</html>
