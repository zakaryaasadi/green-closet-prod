<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendContactUsRequest;
use App\Mail\ContactFromClient;
use App\Models\LocationSettings;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class ContactController
{
    public function sendContactUs(LocationSettings $locationSetting, SendContactUsRequest $request): RedirectResponse
    {
        $name = $request->get('name');
        $emailFrom = $request->get('email');
        $phone = $request->get('phone');
        $details = $request->get('details');

        $email = Setting::where(['country_id' => $locationSetting->country_id])->first()?->mail_receiver
            ?? Setting::where(['country_id' => null])->first()?->mail_receiver;

        if (!$email) {
            $email = config('app.mail_to');
        }

        $sendData = [
            'mail' => $emailFrom ?? '',
            'message' => $details ?? '',
            'user' => $name,
            'user_phone' => $phone,
        ];
        Mail::to($email)->send(new ContactFromClient($sendData));


        return match ($locationSetting->language->code) {
            'ar' => redirect()->back()->with('success', 'شكرًا على تواصلك معنا ، وسنعاود الاتصال بك قريبًا!'),
            default => redirect()->back()->with('success', 'Thanks for contacting us, We will get back to you soon!'),
        };

    }
}
