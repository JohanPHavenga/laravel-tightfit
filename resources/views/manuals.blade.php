<x-base-layout>
    <section id="content">
        <div class="content-wrap-sml">
            <div class="container clearfix">
                <h1>Manuals Download</h1>
                <p>List of manuals to download</p>
                @foreach ($files as $folder => $file_list)
                    <h2>{{ $folder }}</h2>
                    <ul class="iconlist">
                        @foreach ($file_list as $file) 
                        <li><i class="icon-download2" style="top: -1px;"></i> <a href="{{ $file['url'] }}">{{ $file['name'] }}</a></li>
                        @endforeach
                    </ul>
                @endforeach
            </div>

        </div>
    </section>
</x-base-layout>
