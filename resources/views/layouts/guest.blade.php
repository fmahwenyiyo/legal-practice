@php
    use App\Models\Utility;
    $logo =  asset('storage/uploads/logo');

    $company_favicon = Utility::getValByName('company_favicon');
    $setting = Utility::colorset();
    $SITE_RTL =$setting['SITE_RTL'];
    $seo_setting = Utility::getSeoSetting();
    $color = 'theme-1';

    if (!empty($setting['color'])) {
        $color = $setting['color'];
    }

    $SITE_RTL = 'theme-1';
    if (!empty($setting['SITE_RTL'])) {
        $SITE_RTL = $setting['SITE_RTL'];
    }

    $mode_setting = Utility::mode_layout();

    $logo_light = Utility::getValByName('company_logo_light');
    $logo_dark = Utility::getValByName('company_logo_dark');

    $company_logo = Utility::get_company_logo();
    $company_logos = Utility::getValByName('company_logo_light');

@endphp

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{$SITE_RTL == 'on'?'rtl':''}}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="keywords" content="Dashboard Template" />
    <meta name="author" content="Rajodiya Infotech" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> {{ Utility::getValByName('title_text') ? Utility::getValByName('title_text') : config('app.name', 'AdvocateGo-SaaS') }} - @yield('page-title') </title>

    <!-- Primary Meta Tags -->
    <meta name="title" content={{ $seo_setting['meta_keywords'] }}>
    <meta name="description" content={{ $seo_setting['meta_description'] }}>

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content={{ env('APP_URL') }}>
    <meta property="og:title" content={{ $seo_setting['meta_keywords'] }}>
    <meta property="og:description" content={{ $seo_setting['meta_description'] }}>
    <meta property="og:image" content={{ asset(Storage::url('uploads/metaevent/' . $seo_setting['meta_image'])) }}>

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content={{ env('APP_URL') }}>
    <meta property="twitter:title" content={{ $seo_setting['meta_keywords'] }}>
    <meta property="twitter:description" content={{ $seo_setting['meta_description'] }}>
    <meta property="twitter:image" content={{ asset(Storage::url('uploads/metaevent/' . $seo_setting['meta_image'])) }}>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Favicon icon -->

    <link rel="icon" href="{{ $logo . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png') }}" type="image" sizes="800x800">

    <!-- font css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}">

    <!-- vendor css -->

    @if ($SITE_RTL == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-rtl.css') }}" id="main-style-link">
    @endif

    @if ($setting['cust_darklayout'] == 'on')
        <link rel="stylesheet" href="{{ asset('assets/css/style-dark.css') }}">
    @else
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link">
    @endif

    <link rel="stylesheet" href="{{ asset('assets/css/customizer.css') }}">
</head>

<body class="{{ $color }}">
    <!-- [ auth-signup ] start -->
    <div class="auth-wrapper auth-v3">
        <div class="bg-auth-side bg-primary"></div>
        <div class="auth-content">
            <nav class="navbar navbar-expand-md navbar-light default">
                <div class="container-fluid pe-2">

                    <a class="navbar-brand" href="#">
                        @if($mode_setting['cust_darklayout'] && $mode_setting['cust_darklayout'] == 'on' )
                            <img src="{{ $logo . '/' . (isset($company_logos) && !empty($company_logos) ? $company_logos : 'logo-dark.png') }}"
                            alt="{{ config('app.name', 'AdvocateGo-SaaS') }}" class="logo " style="height: 30px; width: 180px;">
                        @else
                            <img src="{{ $logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png') }}"
                            alt="{{ config('app.name', 'AdvocateGo-SaaS') }}" class="logo " style="height: 30px; width: 180px;">
                        @endif
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarTogglerDemo01" style="flex-grow: 0;">
                        <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                @yield('auth-lang')
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>
            <div class="card">
                <div class="row align-items-center text-start">
                    <div class="col-xl-6">
                        <div class="card-body">
                            @yield('content')
                        </div>
                    </div>
                    <div class="col-xl-6 img-card-side">
                        <div class="auth-img-content">
                            <img src="{{ asset('assets/images/auth/img-auth-3.svg') }}" alt="" class="img-fluid" />
                            <h3 class="text-white mb-4 mt-5">
                                “{{ __('Attention is the new currency') }}”
                            </h3>
                            <p class="text-white">
                                {{ __('The more effortless the writing looks, the more effort the writer actually put into the process.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="auth-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">

                            <p class="text-black">
                                {{ App\Models\Utility::getValByName('footer_text') ?
                                App\Models\Utility::getValByName('footer_text') : __('Copyright') .' '. env('APP_NAME') }}
                                {{ date('Y') }}
                            </p>
                        </div>
                        <div class="col-6 text-end">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ auth-signup ] end -->
    @include('layouts.cookie_consent')

    <script src="{{ asset('assets/js/vendor-all.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>

    @stack('custom-scripts')
</body>

</html>
