<?php

use App\Services\ContentFieldInputBuilder;

it('returns null for unsupported input types', function () {
    $html = app(ContentFieldInputBuilder::class)->render('select', 'color');

    expect($html)->toBeNull();
});

it('builds a text input and escapes html values', function () {
    $html = app(ContentFieldInputBuilder::class)
        ->render('text', 'title', '<script>alert(1)</script>');

    expect($html)
        ->toContain('name="content_title"')
        ->toContain('value="&lt;script&gt;alert(1)&lt;/script&gt;"')
        ->not->toContain('<script>alert(1)</script>');
});

it('builds a textarea input', function () {
    $html = app(ContentFieldInputBuilder::class)->render('textarea', 'notes', 'Hello world');

    expect($html)
        ->toContain('<textarea')
        ->toContain('name="content_notes"')
        ->toContain('Hello world');
});

it('builds a checked checkbox when value is truthy', function () {
    $html = app(ContentFieldInputBuilder::class)->render('checkbox', 'featured', '1');

    expect($html)->toContain('checked');
});

it('builds an unchecked checkbox when value is empty', function () {
    $html = app(ContentFieldInputBuilder::class)->render('checkbox', 'featured');

    expect($html)->not->toContain('checked');
});

it('builds a number input', function () {
    $html = app(ContentFieldInputBuilder::class)->render('number', 'stock_count', '42');

    expect($html)
        ->toContain('type="number"')
        ->toContain('name="content_stock_count"')
        ->toContain('value="42"');
});
