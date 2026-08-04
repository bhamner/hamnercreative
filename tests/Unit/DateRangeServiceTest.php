<?php

use App\Services\DateRangeService;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;

it('defaults to last 2 years when no date or route default is provided', function () {
    $request = Request::create('/dashboard', 'GET');

    $result = app(DateRangeService::class)->resolve($request);

    expect($result['selected'])->toBe('last 2 years')
        ->and($result['options'])->toContain(
            'this month',
            'last month',
            'this year',
            'last year',
            'last 2 years',
            'all time'
        )
        ->and($result['params'])->toHaveCount(2)
        ->and($result['period'])->not->toBeNull()
        ->and($result['range'])->not->toBeEmpty();
});

it('uses page-specific defaults based on route name', function (string $routeName, string $expected) {
    $request = requestWithRouteName($routeName);

    $result = app(DateRangeService::class)->resolve($request);

    expect($result['selected'])->toBe($expected);
})->with([
    ['metrics.show', 'this month'],
    ['invoices.index', 'all time'],
    ['content.index', 'last 2 years'],
    ['leads.index', 'last 2 years'],
]);

it('accepts an approved date filter', function (string $date) {
    $request = requestWithRouteName('metrics.show', ['date' => $date]);

    $result = app(DateRangeService::class)->resolve($request);

    expect($result['selected'])->toBe($date)
        ->and($result['params'][0])->toBeString()
        ->and($result['params'][1])->toBeString();
})->with([
    'this month',
    'last month',
    'this year',
    'last year',
    'last 2 years',
    'all time',
]);

it('falls back to the page default for unsupported date filters', function () {
    $request = requestWithRouteName('invoices.index', ['date' => 'next century']);

    $result = app(DateRangeService::class)->resolve($request);

    expect($result['selected'])->toBe('all time');
});

function requestWithRouteName(string $routeName, array $query = []): Request
{
    $request = Request::create('/clients/1/page', 'GET', $query);
    $route = new Route('GET', '/clients/{client}/page', fn () => null);
    $route->name($routeName);
    $request->setRouteResolver(fn () => $route);

    return $request;
}
