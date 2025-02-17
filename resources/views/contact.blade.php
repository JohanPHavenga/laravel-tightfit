<x-base-layout>
    <section id="content">
        <div class="content-wrap-sml">
            <div class="container clearfix">
                <div class="form-widget">
                    <div class="row">
                        <div class="col-lg-12">
                            <h1>Contact Us</h1>
                            <p>Use the form below to send your query to us</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <form method="POST" action="{{ route('contact.store') }}" id="contactForm">
                                    <div class="px-3 my-3">
                                        @include('partials.alerts')
                                    </div>
                                <div class="row justify-content-between">
                                    @csrf
                                    <div class="col-md-6 col-xl-5 mb-3">
                                        <label class="required fw-medium mb-1" for="name">Full Name</label>
                                        <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" id="name"
                                            placeholder="David Hall" value="{{ old('name', isset($name) ? $name : '') }}" required>
                                        <!-- Error -->
                                        @if ($errors->has('name'))
                                            <div class="text-danger">
                                                {{ $errors->first('name') }}
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-12 col-xl-12 mb-3">
                                        <label class="required fw-medium mb-1" for="email">Your Email</label>
                                        <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" name="email" id="email"
                                            placeholder="hello@email.com" value="{{ old('email', isset($email) ? $email : '') }}">
                                        <!-- Error -->
                                        @if ($errors->has('email'))
                                            <div class="text-danger">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="row justify-content-between">
                                    <div class="col-md-12 col-xl-12">
                                        <!-- Start Form Group -->
                                        <label class="required fw-medium mb-1" for="message">Your Message</label>
                                        <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" name="message" rows="7" placeholder="Tell us what we can help you with!">{{ old('message') }}</textarea>
                                        <!-- Error -->
                                        @if ($errors->has('message'))
                                            <div class="text-danger">
                                                {{ $errors->first('message') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-12 col-xl-12">
                                        <input type="hidden" class="" name="subject" value="Website Contact Form">
                                        <!-- Start Submit Button -->
                                        <button class="btn btn-secondary btn-md d-inline-flex hstack gap-2 mt-4 g-recaptcha"
                                            data-sitekey="{{ config('services.recaptcha_v3.siteKey') }}" data-callback='onSubmit' data-action='submit'>
                                            <span>Send message</span>
                                        </button>
                                        <!-- /.End Submit Button -->
                                    </div>
                                </div>
                            </form>
                            <?php
                            // $attributes = ['class' => 'row', 'id' => 'contact'];
                            // echo form_open(base_url('contact'), $attributes);
                            
                            // $field_data = [
                            //     'name' => 'name',
                            //     'id' => 'name',
                            //     'placeholder' => 'Name & Surname',
                            //     'value' => set_value('name'),
                            //     'class' => 'form-control',
                            // ];
                            // echo '<div class="col-6 form-group">';
                            // echo form_input($field_data);
                            // echo '</div>';
                            
                            // $field_data = [
                            //     'name' => 'email',
                            //     'id' => 'email',
                            //     'placeholder' => 'Email Address',
                            //     'value' => set_value('email'),
                            //     'class' => 'form-control',
                            // ];
                            // echo '<div class="col-12 form-group">';
                            // echo form_input($field_data);
                            // echo '</div>';
                            
                            // $field_data = [
                            //     'name' => 'message',
                            //     'id' => 'message',
                            //     'cols' => '10',
                            //     'rows' => '6',
                            //     'placeholder' => 'Message',
                            //     'value' => set_value('message'),
                            //     'class' => 'form-control',
                            // ];
                            // echo '<div class="col-12 form-group">';
                            // echo form_textarea($field_data);
                            // echo '</div>';
                            
                            // echo "<div class='col-12 form-group'>";
                            // echo "<div class='g-recaptcha' data-sitekey='6LfdHsoiAAAAACWdAHZDmH4cUGzUzBc1LnNbIApf'></div>";
                            // echo '</div>';
                            
                            // $field_data = [
                            //     'id' => 'send',
                            //     'class' => 'btn btn-secondary',
                            //     'value' => 'Submit',
                            // ];
                            // echo '<div class="col-12">';
                            // echo form_submit($field_data);
                            // echo '</div>';
                            // echo form_close();
                            ?>
                        </div>
                        <div class="col-lg-4 ps-lg-4">

                            <address>
                                <strong>Address:</strong><br>
                                Unit 9 Alexway Complex, <br>
                                4 Roman Close, Hermanus<br>
                            </address>
                            <abbr title="Phone Number"><strong>Phone:</strong></abbr> <a href="tel:+27828753354">+27 (82) 875 3354</a><br>
                            <abbr title="Fax"><strong>Fax:</strong></abbr> 086 645 0000<br>
                            <abbr title="Email Address"><strong>Email:</strong></abbr>
                            <a href="mailto:tightfit@hermanus.co.za">tightfit@hermanus.co.za</a>

                            <div class="widget border-0 pt-0">

                                <a href="https://www.facebook.com/tightfitgaragedoors" class="social-icon si-small si-dark si-facebook">
                                    <i class="icon-facebook"></i>
                                    <i class="icon-facebook"></i>
                                </a>

                                <a href="https://www.linkedin.com/in/tight-fit-garage-doors-home-automation-hermanus-42b4537b/" class="social-icon si-small si-dark si-linkedin">
                                    <i class="icon-linkedin"></i>
                                    <i class="icon-linkedin"></i>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-base-layout>
