<?php

use App\Models\Client;
use App\Models\Content;
use App\Models\ContentField;
use App\Models\ContentValue;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->withoutVite();
    Storage::fake('local');
});

it('allows a user to view content index for an owned client', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();
    Content::factory()->create([
        'client_id' => $client->id,
        'name' => 'Homepage Hero',
    ]);

    $this->actingAs($user)
        ->get(route('content.index', $client))
        ->assertOk()
        ->assertSee('Homepage Hero')
        ->assertSee($client->name.' — Site content');
});

it('forbids content index for a client the user does not belong to', function () {
    $user = createUserWithClients(2);
    $foreign = Client::factory()->create();

    $this->actingAs($user)
        ->get(route('content.index', $foreign))
        ->assertForbidden();
});

it('allows a multi-client user to view content for a selected client', function () {
    $user = createUserWithClients(2);
    $client = $user->clients()->first();

    $this->actingAs($user)
        ->get(route('content.index', $client))
        ->assertOk();
});

it('allows creating content for an owned client', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $this->actingAs($user)
        ->get(route('content.edit', ['client' => $client]))
        ->assertOk();
});

it('forbids editing content for another client', function () {
    $user = createUserWithClient();
    $content = Content::factory()->create();

    $this->actingAs($user)
        ->get(route('content.edit', [
            'client' => $content->client_id,
            'content' => $content,
        ]))
        ->assertForbidden();
});

it('stores new content and strips html from descriptions', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();

    $field = new ContentField;
    $field->client_id = $client->id;
    $field->name = 'subtitle';
    $field->input_type = 'text';
    $field->save();

    $this->actingAs($user)
        ->post(route('content.store'), [
            'content_name' => 'New Piece',
            'client_id' => $client->id,
            'content_quantity' => '3',
            'content_price' => '19.99',
            'content_in_stock' => '1',
            'content_subtitle' => 'Custom field',
            'quill_contents' => json_encode([
                ['insert' => '<b>Bold</b> and <script>x</script> text'],
            ]),
        ])
        ->assertRedirect(route('content.index', $client));

    $content = Content::query()->where('name', 'New Piece')->first();

    expect($content)->not->toBeNull()
        ->and($content->description)->toBe('Bold and x text')
        ->and($content->in_stock)->toBeTruthy()
        ->and(ContentValue::query()->where('content_id', $content->id)->value('value'))->toBe('Custom field');
});

it('updates existing content for an owned client', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();
    $content = Content::factory()->create([
        'client_id' => $client->id,
        'name' => 'Old Name',
    ]);

    $this->actingAs($user)
        ->post(route('content.store'), [
            'content_id' => $content->id,
            'content_name' => 'Updated Name',
            'client_id' => $client->id,
        ])
        ->assertRedirect(route('content.index', $client));

    expect($content->fresh()->name)->toBe('Updated Name');
});

it('allows deleting owned content', function () {
    $user = createUserWithClient();
    $client = $user->clients()->first();
    $content = Content::factory()->create(['client_id' => $client->id]);

    $this->actingAs($user)
        ->post(route('content.delete', $content))
        ->assertRedirect(route('content.index', $client));

    expect(Content::query()->find($content->id))->toBeNull();
});

it('requires authentication for content routes', function () {
    $client = Client::factory()->create();

    $this->get(route('content.index', $client))->assertRedirect('/');
});
