<x-base-layout>
    <!-- Page header -->
    <div class="bg-white border-b border-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Gallery</p>
                <h1 class="text-2xl font-bold text-gray-900">{{ $data['heading'] }}</h1>
            </div>
            @if (isset($data['supplier_url']))
                <a href="{{ $data['supplier_url'] }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 border border-brand-blue text-brand-blue text-sm font-semibold rounded-lg hover:bg-brand-blue hover:text-white transition-colors duration-150">
                    Supplier Website
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            @endif
        </div>
    </div>

    <!-- Gallery grid -->
    <section class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (!empty($files))
                <p class="text-sm text-gray-500 mb-6">Click any image to view full size</p>
                <div class="masonry-thumbs grid-container grid-4 has-init-isotope" data-big="4" data-lightbox="gallery">
                    @foreach ($files as $file)
                        <a class="grid-item" href="{{ asset($file) }}" data-lightbox="gallery-item">
                            <img src="{{ asset($file) }}" alt="" class="w-full h-full object-cover">
                        </a>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20">
                    <p class="text-gray-400 text-lg">No images to display yet.</p>
                </div>
            @endif
        </div>
    </section>
</x-base-layout>
