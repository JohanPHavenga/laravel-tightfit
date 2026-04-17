<x-base-layout>

    <!-- Page header -->
    <div class="bg-white border-b border-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Company</p>
            <h1 class="text-3xl font-bold text-gray-900">About Us</h1>
        </div>
    </div>

    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                <!-- Main content -->
                <div class="lg:col-span-2 prose prose-gray max-w-none">
                    <p class="text-lg text-gray-700 leading-relaxed">
                        <strong>Tight Fit Garage Doors</strong> was established in August 2008. We have served the Overberg ever since
                        with quality workmanship, honest value and peace of mind. As an owner-run business we have our ear on
                        the pulse of our customers, often providing custom access control solutions to suit their needs.
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-5">
                        We have expanded with the acquisition of both EAC and Carter Fencing in recent times.
                        These businesses' services were incorporated into the offerings of Tight Fit.
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-5">
                        In addition to <strong>garage doors and gate automation</strong> we now offer a turn-key solution to industrial
                        and residential complexes, covering all aspects of access control — electronic and physical. From CCTV
                        and biometric scanners to turnstiles and traffic barriers.
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-5">
                        We embrace the use of the latest technologies and have a firm resolve to upskill our staff constantly.
                        Investment in our staff family is one of our core values. We believe in educating our clients rather
                        than making a quick buck — creating lasting relationships is an important part of our business.
                    </p>
                    <p class="text-gray-600 leading-relaxed mt-5">
                        We have partnered with innovative companies to bring you the best value possible, often cutting out
                        the middle man. Building personal relationships with our suppliers allows us to offer great after-sales service.
                    </p>
                </div>

                <!-- Key facts sidebar -->
                <div class="space-y-6">
                    <div class="rounded-2xl bg-gray-50 border border-gray-200 p-6">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-5">At a Glance</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-brand-blue flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Est. August 2008</p>
                                    <p class="text-xs text-gray-500">Serving the Overberg</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-brand-blue flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Hermanus-based</p>
                                    <p class="text-xs text-gray-500">Owner-run business</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-brand-blue flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">30-day guarantee</p>
                                    <p class="text-xs text-gray-500">On all workmanship</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-brand-blue flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">Full access control</p>
                                    <p class="text-xs text-gray-500">CCTV, biometrics, barriers</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <a href="{{ route('contact.show') }}" class="block text-center px-5 py-3 bg-brand-red text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors">
                        Get a Quote
                    </a>
                </div>

            </div>
        </div>
    </section>

</x-base-layout>
