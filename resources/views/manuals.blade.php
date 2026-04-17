<x-base-layout>

    <!-- Page header -->
    <div class="bg-white border-b border-gray-100 py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Resources</p>
            <h1 class="text-3xl font-bold text-gray-900">Manuals</h1>
        </div>
    </div>

    <section class="py-16 bg-white">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (!empty($files))
                <p class="text-gray-500 mb-10">Download product manuals and documentation below.</p>
                <div class="space-y-10">
                    @foreach ($files as $folder => $file_list)
                        <div>
                            <h2 class="text-lg font-bold text-gray-900 mb-3">{{ $folder }}</h2>
                            <ul class="divide-y divide-gray-100 border border-gray-200 rounded-xl overflow-hidden">
                                @foreach ($file_list as $file)
                                    <li>
                                        <a href="{{ $file['url'] }}"
                                           class="flex items-center gap-3 px-5 py-3.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-brand-blue transition-colors group">
                                            <svg class="w-4 h-4 text-gray-400 group-hover:text-brand-blue flex-shrink-0 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            {{ $file['name'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-gray-400 text-lg">No manuals available at present.</p>
                </div>
            @endif
        </div>
    </section>

</x-base-layout>
