<?php

namespace App\Livewire;

use App\Actions\Contact\SubmitContactMessage;
use App\Services\RecaptchaVerifier;
use Livewire\Attributes\On;
use Livewire\Component;

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
    public function submit(string $token, RecaptchaVerifier $recaptcha, SubmitContactMessage $submit): void
    {
        $validated = $this->validate([
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email'],
            'message' => ['required', 'min:5', 'max:5000'],
        ]);

        $recaptcha->assertValid($token);
        $submit($validated);

        $this->reset();
        session()->flash('success', 'Thank you for your message!');
    }
}
