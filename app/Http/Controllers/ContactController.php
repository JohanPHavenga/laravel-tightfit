<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactEmail;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|max:255',
                'message' => 'required|max:10000',
            ],
            [
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('contact.show')->withErrors($validator)->withInput();
        }

        // Persist first, so the enquiry survives even if the job is lost
        $submission = ContactSubmission::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'subject' => $request->get('subject'),
            'message' => $request->get('message'),
            'ip' => $request->ip(),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 512) ?: null,
            'source' => ContactSubmission::SOURCE_FORM,
        ]);

        //  Send mail to admin
        SendContactEmail::dispatch($submission);

        return redirect()->route('contact.show')->with('success', 'Your message has been sent. We\'ll be in touch shortly.');
    }
}
