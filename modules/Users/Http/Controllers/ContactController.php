<?php

namespace Modules\Users\Http\Controllers;

use Modules\Users\Http\Requests\ContactRequest;
use Pingpong\Modules\Routing\Controller;
use Illuminate\Support\Facades\Mail;
use URL;
use App\Models\Seo;
use App\Helpers\SeoPage;

class ContactController extends Controller {

    public function getContact() {
        SeoPage::seoPage($this);
        $attributes = [
            'data-theme' => 'light',
            'data-type' => 'image',
        ];
        return view("users::contact.form-contact", compact('attributes'));
    }

    public function postContact(ContactRequest $request) {
        if (isset($request)) {
            $data = $request->all();

            Mail::send('users::email.email-contact', ['user' => $data], function ($m) use ($data) {
                $m->from($data["email"], $data["email"]);
                $m->to(EMAIL_BUYPREMIUMKEY, NAME_COMPANY)->subject(SUBJECT_CONTACT);
            });

            $request->session()->flash('alert-success', ' Success: You have successfully sent your contact enquiry');
            return redirect()->route('users.contact.getContact');
        }
    }

}
