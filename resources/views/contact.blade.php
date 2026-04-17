<x-base-layout>
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Heading -->
            <div class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900">Contact Us</h1>
                <p class="mt-2 text-gray-500">Use the form below to send us a message and we'll get back to you shortly.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

                <!-- Form -->
                <div class="lg:col-span-2">
                    <form method="POST" action="{{ route('contact.store') }}">
                        @csrf
                        <x-honeypot />

                        <div class="space-y-5">

                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="David Hall"
                                    class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent transition {{ $errors->has('name') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                                >
                                @error('name')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email Address</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    placeholder="hello@email.com"
                                    class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent transition {{ $errors->has('email') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                                >
                                @error('email')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Message -->
                            <div>
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                                <textarea
                                    id="message"
                                    name="message"
                                    rows="6"
                                    placeholder="Tell us what we can help you with…"
                                    class="w-full rounded-lg border px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-brand-blue focus:border-transparent transition resize-none {{ $errors->has('message') ? 'border-red-400 bg-red-50' : 'border-gray-300' }}"
                                >{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <input type="hidden" name="subject" value="Website Contact Form">

                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-brand-red text-white text-sm font-semibold rounded-lg hover:bg-red-700 transition-colors duration-150">
                                Send Message
                            </button>

                        </div>
                    </form>
                </div>

                <!-- Contact info sidebar -->
                <div class="space-y-6">
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Address</h3>
                        <p class="text-sm text-gray-700 leading-relaxed">
                            Unit 9 Alexway Complex,<br>
                            4 Roman Close,<br>
                            Hermanus
                        </p>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Phone</h3>
                        <a href="https://wa.me/27828753354" class="text-sm text-gray-700 hover:text-brand-blue transition-colors">+27 (82) 875 3354</a>
                    </div>
                    <div>
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Email</h3>
                        <a href="mailto:tightfit@hermanus.co.za" class="text-sm text-gray-700 hover:text-brand-blue transition-colors">tightfit@hermanus.co.za</a>
                    </div>
                    <div class="flex gap-3 pt-2">
                        <a href="https://www.facebook.com/tightfitgaragedoors" class="text-gray-400 hover:text-brand-blue transition-colors" aria-label="Facebook">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="https://www.linkedin.com/in/tight-fit-garage-doors-home-automation-hermanus-42b4537b/" class="text-gray-400 hover:text-brand-blue transition-colors" aria-label="LinkedIn">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>
</x-base-layout>
