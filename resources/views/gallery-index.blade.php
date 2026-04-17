<x-base-layout>

    <!-- Page header + category cards -->
    <section class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Our Work</p>
            <h1 class="text-3xl font-bold text-gray-900 mb-3">Gallery</h1>
            <p class="text-gray-500 mb-10">Browse our installations by category.</p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                <!-- Garage Doors -->
                <a href="{{ url('gallery/garagedoors') }}" class="group block rounded-2xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    <div class="aspect-[4/3] overflow-hidden bg-gray-100">
                        <img src="{{ url('images/projects/1.jpg') }}" alt="Garage Doors"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-5">
                        <h2 class="text-lg font-bold text-gray-900 group-hover:text-brand-blue transition-colors">Garage Doors</h2>
                        <p class="text-sm text-gray-500 mt-1">Aluzinc and aluminium</p>
                        <div class="flex gap-2 mt-4 flex-wrap">
                            <a href="{{ url('gallery/garagedoors/aluzinc') }}" class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-brand-blue hover:text-white transition-colors" @click.stop>Aluzinc</a>
                            <a href="{{ url('gallery/garagedoors/aluminium') }}" class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-brand-blue hover:text-white transition-colors" @click.stop>Aluminium</a>
                        </div>
                        <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-brand-blue">
                            View all
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
                        <h2 class="text-lg font-bold text-gray-900 group-hover:text-brand-blue transition-colors">Door Automation</h2>
                        <p class="text-sm text-gray-500 mt-1">Nice and Centurion systems</p>
                        <div class="flex gap-2 mt-4 flex-wrap">
                            <a href="{{ url('gallery/doorautomation/nice') }}" class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-brand-blue hover:text-white transition-colors" @click.stop>Nice</a>
                            <a href="{{ url('gallery/doorautomation/centurion') }}" class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-brand-blue hover:text-white transition-colors" @click.stop>Centurion</a>
                        </div>
                        <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-brand-blue">
                            View all
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
                        <h2 class="text-lg font-bold text-gray-900 group-hover:text-brand-blue transition-colors">Gate Automation</h2>
                        <p class="text-sm text-gray-500 mt-1">Sliding and swing gates</p>
                        <div class="flex gap-2 mt-4 flex-wrap">
                            <a href="{{ url('gallery/gateautomation/nice') }}" class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-brand-blue hover:text-white transition-colors" @click.stop>Nice</a>
                            <a href="{{ url('gallery/gateautomation/centurion') }}" class="text-xs font-medium px-3 py-1 rounded-full bg-gray-100 text-gray-600 hover:bg-brand-blue hover:text-white transition-colors" @click.stop>Centurion</a>
                        </div>
                        <span class="inline-flex items-center gap-1 mt-4 text-sm font-semibold text-brand-blue">
                            View all
                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>

            </div>
        </div>
    </section>

</x-base-layout>
