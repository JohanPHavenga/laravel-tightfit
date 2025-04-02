<x-base-layout>
    <div class="mt-3">
        @include('partials.alerts')
    </div>
    @include('partials.slider')
    <section id="content">
        <div class="content-wrap">
            <!-- CALL TO ACTION -->
            <div class="promo promo-light promo-full uppercase bottommargin-lg header-stick">
                <div class="container clearfix">
                    <h3 style="letter-spacing: 2px;">Start Planning your New Dream Home</h3>
                    <span>When only the best services and high quality products will do</span>
                    <a href="{{ url('contact') }} }}" class="button button-large button-border button-rounded">Contact Us</a>
                </div>
            </div>

            <!-- SERVICES -->
            <div class="container clearfix">

                <h2 class="center ls1 bottommargin">Tap to read more about our services</h2>

                <div id="portfolio" class="portfolio portfolio-3 grid-container clearfix">

                    <article class="portfolio-item pf-media pf-icons">
                        <div class="portfolio-image">
                            <img src="{{ url('images/projects/1.jpg') }}" alt="Garage Doors">
                            <div class="portfolio-overlay">
                                <a href="{{ url('gallery/garagedoors') }}" class="center-icon"><i class="icon-line-ellipsis"></i></a>
                            </div>
                        </div>
                        <div class="portfolio-desc">
                            <h3><a href="{{ url('gallery/garagedoors') }}">Garage Doors</a></h3>
                            <span>Aluzinc, aluminium</span>
                        </div>
                    </article>

                    <article class="portfolio-item pf-illustrations">
                        <div class="portfolio-image">
                            <img src="{{ url('images/projects/2.jpg') }}" alt="Door Automation">
                            <div class="portfolio-overlay">
                                <a href="{{ url('gallery/doorautomation') }}" class="center-icon"><i class="icon-line-ellipsis"></i></a>
                            </div>
                        </div>
                        <div class="portfolio-desc">
                            <h3><a href="{{ url('gallery/doorautomation') }}">Door Automation</a></h3>
                            <span>Making things go up and down at the push of a button</span>
                        </div>
                    </article>

                    <article class="portfolio-item pf-graphics pf-uielements">
                        <div class="portfolio-image">
                            <img src="{{ url('images/projects/3.jpg') }}" alt="Gate Automation">
                            <div class="portfolio-overlay">
                                <a href="{{ url('gallery/gateautomation') }}" class="center-icon"><i class="icon-line-ellipsis"></i></a>
                            </div>
                        </div>
                        <div class="portfolio-desc">
                            <h3><a href="{{ url('gallery/gateautomation') }}">Gate Automation</a></h3>
                            <span>Sliding or swinging we will make it open</span>
                        </div>
                    </article>

                </div>

            </div>

            <div class="section parallax dark" style="background-image: url('{{ url('images/slider/1.jpg') }}'); padding: 80px 0;" data-bottom-top="background-position:0px 400px;"
                data-top-bottom="background-position:0px -400px;">
                <div class="container clearfix center">

                    <div class="row">
                        <div class="col-lg-12">
                            <h2>TIGHT FIT GARAGE DOORS & AUTOMATION</h2>
                            <p>
                                <a href="{{ url('contact') }}" class="button button-large button-border button-rounded">Contact Us</a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="video-wrap" style="z-index: 1;">
                    <div class="video-overlay" style="background: rgba(3,78,162,0.8);"></div>
                </div>

            </div>

            <div class="section nobg notopmargin nopadding footer-stick">
                <div class="container clearfix">

                    <div class="row">
                        <div class="col-lg-7">
                            <img src="images/remote.jpg" alt="Trust">
                        </div>
                        <div class="col-lg-5 topmargin-sm">
                            <div class="heading-block nobottomborder">
                                <h2>You're in Good Hands.</h2>
                                <span class="ls1">Five Points that define Our Service</span>
                            </div>

                            <ul class="iconlist iconlist-large iconlist-color">
                                <li><i class="icon-ok"></i> Locally own business since 2002</li>
                                <li><i class="icon-ok"></i> Long list of happy customers</li>
                                <li><i class="icon-ok"></i> Professional on-time workmen</li>
                                <li><i class="icon-ok"></i> We back our workmanship with a 30day guarantee</li>
                                <li><i class="icon-ok"></i> Only the best quality products will do</li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</x-base-layout>
