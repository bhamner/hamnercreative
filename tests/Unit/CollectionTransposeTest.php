<?php

it('transposes service form arrays into keyed rows', function () {
    $rows = collect([
        'service_name' => ['Design', 'Dev'],
        'service_rate' => ['100', '200'],
        'service_quantity' => ['1', '2'],
    ])->transpose();

    expect($rows)->toHaveCount(2)
        ->and($rows->first())->toMatchArray([
            'service_name' => 'Design',
            'service_rate' => '100',
            'service_quantity' => '1',
        ])
        ->and($rows->last())->toMatchArray([
            'service_name' => 'Dev',
            'service_rate' => '200',
            'service_quantity' => '2',
        ]);
});

it('filters blank transposed service rows', function () {
    $rows = collect([
        'service_name' => ['Design', null],
        'service_rate' => ['100', null],
        'service_quantity' => ['1', null],
    ])->transpose();

    expect($rows)->toHaveCount(1)
        ->and($rows->first()['service_name'])->toBe('Design');
});
