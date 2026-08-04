<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\Content;
use App\Models\Order;
use App\Models\User;
use App\Policies\ClientPolicy;
use App\Policies\ContentPolicy;
use App\Policies\OrderPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Client::class => ClientPolicy::class,
        Content::class => ContentPolicy::class,
        Order::class => OrderPolicy::class,
        User::class => UserPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
