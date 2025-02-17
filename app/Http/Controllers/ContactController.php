<?php

namespace App\Http\Controllers;

use App\Rules\ReCaptchaV3;
use Illuminate\Http\Request;
use App\Jobs\SendContactEmail;
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
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required',
                // 'g-recaptcha-response' => ['required', new ReCaptchaV3()]
            ],
            [
            ]
        );

        if ($validator->fails()) {
            return redirect()->route('contact.show')->withErrors($validator)->withInput();
        } else {
            //  Send mail to admin
            dispatch(new SendContactEmail(
                [
                    'subject' => $request->get('subject'),
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'message' => nl2br($request->get('message')),
                ]
            ));

            return redirect()->route('contact.success')->with('success', 'Your contact request has been send.');
        }
    }

    public function success()
    {
        return view('notice');
    }
}
