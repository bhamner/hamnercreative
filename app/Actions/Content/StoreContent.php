<?php

namespace App\Actions\Content;

use App\Models\Client;
use App\Models\Content;
use App\Models\ContentValue;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class StoreContent
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function __invoke(array $data, Client $client, ?Content $content = null): Content
    {
        $content ??= new Content;
        $content->client_id = $client->id;
        $content->name = $data['content_name'];
        $content->description = $this->descriptionFromQuill($data['quill_contents'] ?? null);
        $content->quantity_available = $data['content_quantity'] ?? null;
        $content->price = $data['content_price'] ?? null;
        $content->in_stock = (bool) ($data['content_in_stock'] ?? false);

        if (($data['content_image'] ?? null) instanceof UploadedFile) {
            $content->image = $this->storeImage($data['content_image']);
        }

        $content->save();
        $this->syncCustomFields($content, $client, $data);

        return $content->fresh(['content_values']);
    }

    protected function descriptionFromQuill(mixed $quillContents): ?string
    {
        $decoded = json_decode(is_string($quillContents) ? $quillContents : '', false);

        if (! is_array($decoded) || ! isset($decoded[0]->insert)) {
            return null;
        }

        $description = (string) $decoded[0]->insert;

        return strlen($description) > 1 ? strip_tags($description) : null;
    }

    protected function storeImage(UploadedFile $file): string
    {
        $path = Storage::putFile('public', $file);
        ImageOptimizer::optimize(storage_path('app/'.$path));

        return config('app.url').'/'.str_replace('public', 'storage', $path);
    }

    /**
     * @param  array<string, mixed>  $data
     */
    protected function syncCustomFields(Content $content, Client $client, array $data): void
    {
        foreach ($client->content_fields as $field) {
            $key = 'content_'.$field->name;

            ContentValue::updateOrCreate(
                [
                    'client_content_field_id' => $field->id,
                    'content_id' => $content->id,
                ],
                [
                    'value' => array_key_exists($key, $data) ? $data[$key] : null,
                ]
            );
        }
    }
}
