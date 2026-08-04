<?php

namespace App\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;

class DateRangeService
{
    public const DEFAULT = 'last 2 years';

    /**
     * @return array{
     *     params: array{0: string, 1: string},
     *     period: Period,
     *     selected: string,
     *     range: array<int, Carbon>,
     *     options: array<int, string>
     * }
     */
    public function resolve(Request $request): array
    {
        $ranges = $this->approvedRanges();
        $default = $this->defaultForRoute($request->route()?->getName());
        $selected = $request->query('date', $default);

        if (! array_key_exists($selected, $ranges)) {
            $selected = $default;
        }

        [$start, $end] = $ranges[$selected];
        $limitedStart = $this->limitStartDate($start, $end);

        return [
            'params' => $ranges[$selected],
            'period' => Period::create(Carbon::parse($limitedStart), Carbon::parse($end)),
            'selected' => $selected,
            'range' => CarbonPeriod::create(Carbon::parse($limitedStart), Carbon::parse($end))->toArray(),
            'options' => array_keys($ranges),
        ];
    }

    public function defaultForRoute(?string $routeName): string
    {
        return match ($routeName) {
            'metrics.show' => 'this month',
            'invoices.index' => 'all time',
            'content.index', 'leads.index' => 'last 2 years',
            default => self::DEFAULT,
        };
    }

    /**
     * @return array<string, array{0: string, 1: string}>
     */
    protected function approvedRanges(): array
    {
        $end = Carbon::now()->toDateTimeString();

        return [
            'last month' => [
                Carbon::yesterday()->subMonthNoOverflow()->startOfMonth()->toDateTimeString(),
                Carbon::now()->startOfMonth()->toDateTimeString(),
            ],
            'this month' => [
                Carbon::yesterday()->startOfMonth()->toDateTimeString(),
                $end,
            ],
            'this year' => [
                Carbon::yesterday()->startOfYear()->toDateTimeString(),
                $end,
            ],
            'last year' => [
                Carbon::yesterday()->subYears(1)->startOfYear()->toDateTimeString(),
                Carbon::now()->startOfYear()->toDateTimeString(),
            ],
            'last 2 years' => [
                Carbon::now()->subYears(2)->startOfDay()->toDateTimeString(),
                $end,
            ],
            'all time' => [
                Carbon::yesterday()->startOfCentury()->toDateTimeString(),
                $end,
            ],
        ];
    }

    protected function limitStartDate(string $start, string $end): string|int
    {
        $ninetyDaysAgo = strtotime($end.' -90 days');

        return strtotime($start) < $ninetyDaysAgo ? $ninetyDaysAgo : $start;
    }
}
