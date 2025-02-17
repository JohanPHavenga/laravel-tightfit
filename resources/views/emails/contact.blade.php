@include('emails.header')
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hi</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">See below for a contact request query from the TightFit website.</p>

<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
    <b>Name:</b> {{ $name }} <br>
    <b>Email:</b> {{ $email }} <br>
</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><b>Message:</b><br>{!! $mail_message !!}</p>
@include('emails.footer')
