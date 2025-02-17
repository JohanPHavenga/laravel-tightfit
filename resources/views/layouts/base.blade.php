<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ config('app.name', 'TightFit Garage Doors & Automation') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="site.webmanifest">
    <link rel="mask-icon" href="{{ url('images/favicon/safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ url('css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/swiper.css') }}" type="text/css" />

    <!-- Construction Demo Specific Stylesheet -->
    <link rel="stylesheet" href="{{ url('css/construction.css') }}" type="text/css" />
    <!-- / -->

    <link rel="stylesheet" href="{{ url('css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/magnific-popup.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ url('css/fonts.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ url('css/responsive.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ url('css/colors.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ url('css/custom.css') }}" type="text/css" />

</head>

<body class="stretched">
    <div id="wrapper" class="clearfix">

        <header id="header" class="sticky-style-2">
            <div class="container clearfix">

                <div id="logo">
                    <a href="{{ url('/') }}" class="standard-logo"><img src="{{ url('images/logo.png') }}" alt="Canvas Logo"></a>
                    <a href="{{ url('/') }}" class="retina-logo"><img src="{{ url('images/logo@2x.png') }}" alt="Canvas Logo"></a>
                </div>

                <ul class="header-extras">
                    <li>
                        <i class="i-plain icon-call nomargin"></i>
                        <div class="he-text">
                            Call Us
                            <span><a href="tel:+27828753354">+27 (82) 875 3354</a></span>
                        </div>
                    </li>
                    <li>
                        <i class="i-plain icon-line2-envelope nomargin"></i>
                        <div class="he-text">
                            Email Us
                            <span>
                                <a href="mailto:tightfit@hermanus.co.za" class="">tightfit@hermanus.co.za</a>
                            </span>
                        </div>
                    </li>
                </ul>

            </div>
            <div id="header-wrap">

                <!-- Primary Navigation
                    ============================================= -->
                <nav id="primary-menu" class="with-arrows style-2 center">
                    <div class="container clearfix">
                        <div id="primary-menu-trigger"><i class="icon-reorder"></i></div>
                        <ul>
                            <li class="current"><a href="{{ route('home') }}"><div>Home</div></a></li>
                            <li><a href="{{ url('gallery/garagedoors') }}"><div>Garage Doors</div></a>
                                <ul>
                                    <li><a href="{{ url('gallery/garagedoors/aluzinc') }}"><div>Aluzinc</div></a></li>
                                    <li><a href="{{ url('gallery/garagedoors/aluminium') }}"><div>Aluminium</div></a></li>
                                </ul>
                            </li>
                            <li><a href="{{ url('gallery/doorautomation') }}"><div>Door Automation</div></a>
                                <ul>
                                    <li><a href="{{ url('gallery/doorautomation/nice') }}"><div>Nice</div></a></li>
                                    <li><a href="{{ url('gallery/doorautomation/centurion') }}"><div>Centurion</div></a></li>
                                </ul>
                            </li>
                            <li><a href="{{ url('gallery/gateautomation') }}"><div>Gate Automation</div></a>
                                <ul>
                                    <li><a href="{{ url('gallery/gateautomation/nice') }}"><div>Nice</div></a></li>
                                    <li><a href="{{ url('gallery/gateautomation/centurion') }}"><div>Centurion</div></a></li>
                                </ul>
                            </li>
                            <li><a href="{{ route('manuals') }}"><div>Manuals</div></a></li>
                            <li><a href="{{ route('about') }}"><div>About</div></a></li>
                            <li><a href="{{ route('contact.show') }}"><div>Contact</div></a></li>
                        </ul>
                    </div>
                </nav><!-- #primary-menu end -->
            </div>
        </header><!-- #header end -->

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <footer id="footer" class="dark">
            <div id="copyrights">        
                <div class="container clearfix">        
                    <div class="col_one_fifth nobottommargin">
                        <img src="{{ url("images/footer-logo.png") }}" alt="" class="footer-logo">
                    </div>
        
                    <div class="col_four_fifth col_last tright nobottommargin">
                        <div class="copyrights-menu copyright-links fright clearfix">
                            <a href="{{ url('/') }}">Home</a>/
                            <a href="{{ url("gallery/garagedoors") }}">Garage Doors</a>/
                            <a href="{{ url("gallery/doorautomation") }}">Door Automation</a>/
                            <a href="{{ url("gallery/gateautomation") }}">Gate Automation</a>/
                            <a href="{{ url("manuals") }}">Manuals</a>/
                            <a href="{{ url("about") }}">About</a>/
                            <a href="{{ url("contact") }}">Contact</a>
                            <br>
                            <span style="font-weight: normal;">Copyrights &copy; {{ date("Y") }} All Rights Reserved by TightFit Garage Doors & Automation.</span>
                        </div>
                        <div class="fright clearfix" style="clear: both;">
                            <a href="https://www.facebook.com/tightfitgaragedoors" class="social-icon si-small si-borderless nobottommargin si-facebook">
                                <i class="icon-facebook"></i>
                                <i class="icon-facebook"></i>
                            </a>
        
                            <a href="https://www.linkedin.com/in/tight-fit-garage-doors-home-automation-hermanus-42b4537b/" class="social-icon si-small si-borderless nobottommargin si-linkedin">
                                <i class="icon-linkedin"></i>
                                <i class="icon-linkedin"></i>
                            </a>
                        </div>
                    </div>
                </div>
        
            </div><!-- #copyrights end -->
        
        </footer>


    </div>
    <div id="gotoTop" class="icon-angle-up"></div>
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('js/plugins.js') }}"></script>
    
    <!-- Footer Scripts
    ============================================= -->
    <script src="{{ url('js/functions.js') }}"></script>
    @if (isset($scripts_to_load))
        @foreach ($scripts_to_load as $row)
            @if (substr($row, 0, 4) == 'http')
                <script src='{{ substr($row, 0, 4) == 'http' ? $row : url($row) }}' type='text/javascript'></script>";
            @endif
        @endforeach
    @endif
</body>

</html>
