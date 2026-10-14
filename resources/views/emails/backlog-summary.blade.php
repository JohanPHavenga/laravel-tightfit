@include('emails.header')
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">Hi</p>
<p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
    Because of a website fault, the following {{ $submissions->count() }} enquiries submitted between {{ $first }} and {{ $last }}
    were not delivered at the time. We apologise for the inconvenience. They are listed oldest first.
</p>

@foreach ($submissions as $submission)
    <hr style="border: 0; border-top: 1px solid #dddddd; margin: 20px 0;">
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;">
        <b>Date:</b> {{ $submission->created_at->timezone('Africa/Johannesburg')->format('j M Y, H:i') }} <br>
        <b>Name:</b> {{ $submission->name }} <br>
        <b>Email:</b> <a href="mailto:{{ $submission->email }}">{{ $submission->email }}</a> <br>
    </p>
    <p style="font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px;"><b>Message:</b><br>{!! nl2br(e($submission->message)) !!}</p>
@endforeach
@include('emails.footer')
