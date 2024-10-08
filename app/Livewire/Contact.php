<?php

namespace App\Livewire;

use Arr;
use Livewire\Component;
use Livewire\Attributes\On; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate; 
use Illuminate\Validation\ValidationException;

class Contact extends Component
{
 
    public $name;
 
    public $email;

    public $message;
     
    public function render()
    {
        return view('livewire.contact');
    }


    #[On('formSubmitted')]
    public function submit($token): void
    {
        $this->validate([ 
            'name' => 'required|min:5',
            'email' => 'required|email',
            'message' => 'required|min:5',
        ]);
        $this->validateRecaptcha($token);
        $this->store($this->all());
        $this->reset();
        session()->flash('success','Thank you for your message!');
    }

    protected function validateRecaptcha(string $token): void
    {
        // validate Google reCaptcha.
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha_v3.secretKey'),
            'response' => $token,
            'remoteip' => request()->ip(),
        ]);
        $throw = fn ($message) => throw ValidationException::withMessages(['recaptcha' => $message]);
        if (! $response->successful() || ! $response->json('success')) {
            $throw($response->json(['error-codes'])[0] ?? 'An error occurred.');
        }
        // if response was score based (the higher the score, the more trustworthy the request)
        if ($response->json('score') < 0.6) {
            $throw('We were unable to verify that you\'re not a robot. Please try again.');
        }
    }

    protected function store($params)
    {
        Mail::to( config('contact.email') )->send(new \App\Mail\ContactForm($params));
    }

    protected function rules(): array
    {
         return app(Contact::class)::rules();
    }
}
