<x-base-layout>
    <section id="content">
        <div class="content-wrap-sml">
            <div class="container clearfix">
                <h1>{{ $data['heading'] }}</h1>
                @if (!empty($files))
                    <p>Below find a sample of the product we install.</p>
                    <div class="masonry-thumbs grid-container grid-4 has-init-isotope" data-big="4" data-lightbox="gallery" style="position: relative;">
                        @foreach ($files as $file)
                            <a class='grid-item' href='{{ url('storage/' . $file) }}' data-lightbox='gallery-item' style='position: absolute; left: 0%; top: 0px;'>
                                <img src='{{ url('storage/' . $file) }}' alt=''>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p>No samples to display</p>
                @endif

                @if (isset($data['supplier_url']))
                    <div class="row">
                        <div class="col-12 mt-4"> 
                            <a href="{{ $data['supplier_url'] }}" class="btn btn-secondary" target="_blank">Supplier Website</a>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </section>
</x-base-layout>
