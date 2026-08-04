<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(UrlGenerator $urlGenerator): void
    {
        if (App::environment('production')) {
            $urlGenerator->forceScheme('https');
        }

        Collection::macro('transpose', function () {
            /** @var Collection<array-key, mixed> $collection */
            $collection = $this;

            $keys = $collection->keys()->all();
            $values = $collection->values()->all();

            $items = array_map(function (...$row) use ($keys) {
                if (array_filter($row)) {
                    return array_combine($keys, $row);
                }
            }, ...$values);

            return new static(array_filter($items));
        });
    }
}
