<x-base-layout>

    {{-- ================================================================
         HERO
    ================================================================ --}}
    <section class="relative h-[75vh] min-h-[500px] flex items-center bg-brand-dark overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ url('images/slider/5.jpg') }}');"></div>
        <div class="absolute inset-0 bg-brand-dark/75"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-2xl">
                <p class="text-brand-red font-semibold text-sm uppercase tracking-widest mb-4">Hermanus &amp; the Overberg</p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-tight">
                    Garage Doors<br>&amp; Automation
                </h1>
                <p class="mt-5 text-lg text-gray-300 leading-relaxed">
                    Quality workmanship and trusted products for residential and commercial clients since&nbsp;2008.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ url('gallery/garagedoors') }}" class="inline-flex items-center px-6 py-3 bg-brand-red text-white font-semibold rounded-lg hover:bg-red-700 transition-colors duration-150">
                        View Our Work
                    </a>
                    <a href="{{ route('contact.show') }}" class="inline-flex items-center px-6 py-3 border-2 border-white/40 text-white font-semibold rounded-lg hover:border-white hover:bg-white/10 transition-colors duration-150">
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>

    {{-- ================================================================
         SERVICES
    ================================================================ --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900">What We Do</h2>
                <p class="mt-3 text-gray-500">Tap a category to browse our work</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <!-- Garage Doors -->
                <a href="{{ url('gallery/garagedoors') }}" class="group block rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                        <img src="{{ url('images/projects/1.jpg') }}" alt="Garage Doors"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-blue transition-colors">Garage Doors</h3>
                        <p class="text-sm text-gray-500 mt-1">Aluzinc and aluminium</p>
                        <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-brand-blue">
                            View Gallery
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>

                <!-- Door Automation -->
                <a href="{{ url('gallery/doorautomation') }}" class="group block rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                        <img src="{{ url('images/projects/2.jpg') }}" alt="Door Automation"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-blue transition-colors">Door Automation</h3>
                        <p class="text-sm text-gray-500 mt-1">Nice and Centurion systems</p>
                        <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-brand-blue">
                            View Gallery
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>

                <!-- Gate Automation -->
                <a href="{{ url('gallery/gateautomation') }}" class="group block rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                        <img src="{{ url('images/projects/3.jpg') }}" alt="Gate Automation"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-brand-blue transition-colors">Gate Automation</h3>
                        <p class="text-sm text-gray-500 mt-1">Sliding and swing gates</p>
                        <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-brand-blue">
                            View Gallery
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>

            </div>
        </div>
    </section>

    {{-- ================================================================
         CTA STRIP
    ================================================================ --}}
    <section class="bg-brand-blue py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div>
                <h2 class="text-2xl font-bold text-white">Need a new garage door or automation system?</h2>
                <p class="text-blue-200 mt-1 text-sm">We service the Hermanus and Overberg area.</p>
            </div>
            <a href="{{ route('contact.show') }}" class="flex-shrink-0 inline-flex items-center px-6 py-3 bg-white text-brand-blue font-semibold rounded-lg hover:bg-gray-100 transition-colors duration-150">
                Get in Touch
            </a>
        </div>
    </section>

    {{-- ================================================================
         TRUST / WHY US
    ================================================================ --}}
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

                <div class="rounded-2xl overflow-hidden shadow-md">
                    <img src="{{ url('images/remote.jpg') }}" alt="TightFit remote control" class="w-full h-full object-cover">
                </div>

                <div>
                    <h2 class="text-3xl font-bold text-gray-900">You're in Good Hands</h2>
                    <p class="mt-3 text-gray-500">Five things that define our service</p>

                    <ul class="mt-8 space-y-4">
                        @foreach([
                            'Locally owned business since 2002',
                            'Long list of happy customers',
                            'Professional, on-time workmen',
                            '30-day workmanship guarantee',
                            'Only the best quality products',
                        ] as $point)
                        <li class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-brand-blue flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">{{ $point }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('about') }}" class="inline-flex items-center gap-2 mt-8 text-sm font-semibold text-brand-blue hover:text-blue-800 transition-colors">
                        More about us
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
    </section>

</x-base-layout>
