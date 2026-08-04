<?php

use App\Livewire\Contact;
use App\Mail\ContactForm;
use App\Models\Contact as ContactModel;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;

beforeEach(function () {
    $this->withoutVite();
    Mail::fake();
    config(['contact.email' => 'owner@example.com']);
});

it('renders the contact component', function () {
    Livewire::test(Contact::class)->assertOk();
});

it('validates required contact fields', function () {
    Livewire::test(Contact::class)
        ->set('name', '')
        ->set('email', 'not-an-email')
        ->set('message', 'hi')
        ->call('submit', 'token')
        ->assertHasErrors(['name', 'email', 'message']);
});

it('rejects low recaptcha scores', function () {
    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => true,
            'score' => 0.1,
        ]),
    ]);

    Livewire::test(Contact::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('message', 'Hello there friend')
        ->call('submit', 'token')
        ->assertHasErrors(['recaptcha']);

    expect(ContactModel::query()->count())->toBe(0);
    Mail::assertNothingSent();
});

it('stores a contact message and sends mail when recaptcha passes', function () {
    Http::fake([
        'https://www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => true,
            'score' => 0.9,
        ]),
    ]);

    Livewire::test(Contact::class)
        ->set('name', 'Jane Doe')
        ->set('email', 'jane@example.com')
        ->set('message', 'Hello there friend')
        ->call('submit', 'token')
        ->assertHasNoErrors()
        ->assertSet('name', null)
        ->assertSet('email', null)
        ->assertSet('message', null);

    expect(ContactModel::query()->first())
        ->name->toBe('Jane Doe')
        ->email->toBe('jane@example.com')
        ->message->toBe('Hello there friend');

    Mail::assertSent(ContactForm::class, function (ContactForm $mail) {
        return $mail->hasTo('owner@example.com');
    });
});
