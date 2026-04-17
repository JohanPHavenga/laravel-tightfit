<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TightFit Garage Doors & Automation') }}</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('images/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('images/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="site.webmanifest">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Tailwind + Alpine -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Theme assets (lightbox, isotope, icon fonts) -->
    <link rel="stylesheet" href="{{ url('css/style.css') }}">
    <link rel="stylesheet" href="{{ url('css/font-icons.css') }}">
    <link rel="stylesheet" href="{{ url('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('css/custom.css') }}">
</head>

<body class="font-sans antialiased bg-white text-gray-900">

    <!-- ============================================================
         HEADER
    ============================================================ -->
    <header
        x-data="{ open: false, galleryOpen: false, scrolled: false }"
        @scroll.window="scrolled = window.scrollY > 10"
        :class="scrolled ? 'shadow-md' : 'border-b border-gray-100'"
        class="sticky top-0 z-50 bg-white transition-shadow duration-200"
    >
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <img src="{{ url('images/logo.png') }}" alt="TightFit Garage Doors & Automation" class="h-14 w-auto">
                </a>

                <!-- Desktop nav -->
                <nav class="max-lg:hidden flex items-center gap-7">
                    <a href="{{ route('home') }}" class="text-sm font-medium text-gray-600 hover:text-brand-blue transition-colors duration-150">
                        Home
                    </a>

                    <!-- Gallery dropdown -->
                    <div class="relative" @mouseenter="galleryOpen = true" @mouseleave="galleryOpen = false">
                        <a href="{{ route('gallery.index') }}" class="flex items-center gap-1 text-sm font-medium text-gray-600 hover:text-brand-blue transition-colors duration-150">
                            Gallery
                            <svg class="w-4 h-4 transition-transform duration-150" :class="galleryOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                        <div
                            x-cloak
                            x-show="galleryOpen"
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
                            class="absolute left-0 top-full mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50"
                        >
                            <span class="block px-4 pt-2 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Garage Doors</span>
                            <a href="{{ url('gallery/garagedoors/aluzinc') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-blue transition-colors">Aluzinc</a>
                            <a href="{{ url('gallery/garagedoors/aluminium') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-blue transition-colors">Aluminium</a>
                            <div class="my-1.5 border-t border-gray-100"></div>
                            <span class="block px-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Door Automation</span>
                            <a href="{{ url('gallery/doorautomation/nice') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-blue transition-colors">Nice</a>
                            <a href="{{ url('gallery/doorautomation/centurion') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-blue transition-colors">Centurion</a>
                            <div class="my-1.5 border-t border-gray-100"></div>
                            <span class="block px-4 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Gate Automation</span>
                            <a href="{{ url('gallery/gateautomation/nice') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-blue transition-colors">Nice</a>
                            <a href="{{ url('gallery/gateautomation/centurion') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-blue transition-colors">Centurion</a>
                        </div>
                    </div>

                    <a href="{{ route('manuals') }}" class="text-sm font-medium text-gray-600 hover:text-brand-blue transition-colors duration-150">
                        Manuals
                    </a>
                    <a href="{{ route('about') }}" class="text-sm font-medium text-gray-600 hover:text-brand-blue transition-colors duration-150">
                        About
                    </a>
                    <a href="tel:+27828753354" class="text-sm font-medium text-brand-red hover:text-red-700 transition-colors duration-150">
                        +27 (82) 875 3354
                    </a>
                    <a href="{{ route('contact.show') }}" class="inline-flex items-center px-4 py-2 bg-brand-red text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors duration-150">
                        Contact Us
                    </a>
                </nav>

                <!-- Mobile hamburger -->
                <button
                    @click="open = !open"
                    class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors"
                    aria-label="Toggle menu"
                >
                    <svg x-show="!open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                    <svg x-show="open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>
        </div>

        <!-- Mobile menu -->
        <div
            x-cloak
            x-show="open"
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="lg:hidden border-t border-gray-100 bg-white pb-4"
        >
            <div class="max-w-7xl mx-auto px-4 space-y-1 pt-2">
                <a href="{{ route('home') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Home</a>

                <div x-data="{ mobileGallery: false }">
                    <div class="flex items-center rounded-lg hover:bg-gray-50">
                        <a href="{{ route('gallery.index') }}" class="flex-1 px-3 py-2.5 text-sm font-medium text-gray-700">Gallery</a>
                        <button @click="mobileGallery = !mobileGallery" class="px-3 py-2.5 text-gray-500" aria-label="Expand gallery menu">
                            <svg class="w-4 h-4 transition-transform duration-150" :class="mobileGallery ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                    </div>
                    <div x-cloak x-show="mobileGallery" class="mt-1 pl-3">
                        <span class="block px-3 py-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Garage Doors</span>
                        <a href="{{ url('gallery/garagedoors/aluzinc') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-blue">Aluzinc</a>
                        <a href="{{ url('gallery/garagedoors/aluminium') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-blue">Aluminium</a>
                        <span class="block px-3 pt-2 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Door Automation</span>
                        <a href="{{ url('gallery/doorautomation/nice') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-blue">Nice</a>
                        <a href="{{ url('gallery/doorautomation/centurion') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-blue">Centurion</a>
                        <span class="block px-3 pt-2 pb-1 text-xs font-semibold text-gray-400 uppercase tracking-wider">Gate Automation</span>
                        <a href="{{ url('gallery/gateautomation/nice') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-blue">Nice</a>
                        <a href="{{ url('gallery/gateautomation/centurion') }}" class="block px-3 py-2 text-sm text-gray-600 hover:text-brand-blue">Centurion</a>
                    </div>
                </div>

                <a href="{{ route('manuals') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Manuals</a>
                <a href="{{ route('about') }}" class="block px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">About</a>
                <a href="tel:+27828753354" class="block px-3 py-2.5 text-sm font-semibold text-brand-red hover:bg-gray-50 rounded-lg">
                    +27 (82) 875 3354
                </a>
                <div class="pt-1">
                    <a href="{{ route('contact.show') }}" class="block text-center px-4 py-2.5 bg-brand-red text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- ============================================================
         PAGE CONTENT
    ============================================================ -->
    <main>
        @if(Session::has('warning') || Session::has('failure') || $errors->any())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6">
                @include('partials.alerts')
            </div>
        @endif
        {{ $slot }}
    </main>

    <!-- ============================================================
         FOOTER
    ============================================================ -->
    <footer class="bg-brand-dark text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <!-- Brand -->
                <div>
                    <img src="{{ url('images/footer-logo.png') }}" alt="TightFit" class="h-12 w-auto mb-5">
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Quality garage doors and automation solutions for the Overberg since 2008.
                    </p>
                    <div class="flex gap-4 mt-5">
                        <a href="https://www.facebook.com/tightfitgaragedoors" class="text-gray-500 hover:text-white transition-colors" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/in/tight-fit-garage-doors-home-automation-hermanus-42b4537b/" class="text-gray-500 hover:text-white transition-colors" aria-label="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Contact -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Contact</h3>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="tel:+27828753354" class="text-gray-400 hover:text-white transition-colors">+27 (82) 875 3354</a>
                        </li>
                        <li>
                            <a href="mailto:tightfit@hermanus.co.za" class="text-gray-400 hover:text-white transition-colors">tightfit@hermanus.co.za</a>
                        </li>
                        <li class="text-gray-500 leading-relaxed">
                            Unit 9 Alexway Complex,<br>4 Roman Close, Hermanus
                        </li>
                    </ul>
                </div>

                <!-- Navigation -->
                <div>
                    <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Navigation</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition-colors">Home</a></li>
                        <li><a href="{{ url('gallery/garagedoors') }}" class="text-gray-400 hover:text-white transition-colors">Garage Doors</a></li>
                        <li><a href="{{ url('gallery/doorautomation') }}" class="text-gray-400 hover:text-white transition-colors">Door Automation</a></li>
                        <li><a href="{{ url('gallery/gateautomation') }}" class="text-gray-400 hover:text-white transition-colors">Gate Automation</a></li>
                        <li><a href="{{ route('manuals') }}" class="text-gray-400 hover:text-white transition-colors">Manuals</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-400 hover:text-white transition-colors">About</a></li>
                        <li><a href="{{ route('contact.show') }}" class="text-gray-400 hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>

            </div>

            <div class="mt-10 pt-6 border-t border-white/10 text-center text-xs text-gray-600">
                &copy; {{ date('Y') }} TightFit Garage Doors &amp; Automation. All rights reserved.
            </div>
        </div>
    </footer>

    <!-- Toast notification -->
    <x-toast />

    <!-- Theme JS (required for gallery lightbox + isotope grid) -->
    <script src="{{ url('js/jquery.js') }}"></script>
    <script src="{{ url('js/plugins.js') }}"></script>
    <script src="{{ url('js/functions.js') }}"></script>

</body>
</html>
