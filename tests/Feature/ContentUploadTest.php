<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->withoutVite();
    Storage::fake('local');
});

it('rejects svg content image uploads', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)
        ->post(route('content.store'), [
            'content_name' => 'Test item',
            'client_id' => $client->id,
            'content_image' => UploadedFile::fake()->create('malware.svg', 100, 'image/svg+xml'),
        ])
        ->assertSessionHasErrors('content_image');
});

it('accepts raster content image uploads', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)
        ->post(route('content.store'), [
            'content_name' => 'Test item',
            'client_id' => $client->id,
            'content_image' => UploadedFile::fake()->image('photo.jpg'),
        ])
        ->assertSessionDoesntHaveErrors('content_image');
});
