<?php

namespace App\Actions\Contact;

use App\Mail\ContactForm;
use App\Models\Contact;
use Illuminate\Support\Facades\Mail;

class SubmitContactMessage
{
    /**
     * @param  array{name: string, email: string, message: string}  $data
     */
    public function __invoke(array $data): Contact
    {
        $contact = Contact::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
        ]);

        Mail::to(config('contact.email'))->send(new ContactForm($data));

        return $contact;
    }
}
