<?php

namespace App\Actions\Content;

use App\Models\Content;

class DeleteContent
{
    public function __invoke(Content $content): int
    {
        $clientId = $content->client_id;
        $content->content_values()->delete();
        $content->delete();

        return $clientId;
    }
}
