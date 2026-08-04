<?php

namespace App\Services;

use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Analytics\Facades\Analytics;
use Spatie\Analytics\Period;

class AnalyticsDashboardService
{
    /**
     * @param  array{period: Period, range: array<int, Carbon>}  $dates
     * @return array<int|string, array<string, int>>
     */
    public function forClient(Client $client, array $dates): array
    {
        return $this->forClients(collect([$client]), $dates);
    }

    /**
     * @param  array{period: Period, range: array<int, Carbon>}  $dates
     * @return array<int|string, array<string, int>>
     */
    public function forUser(User $user, array $dates): array
    {
        return $this->forClients($user->clients, $dates);
    }

    /**
     * @param  Collection<int, Client>  $clients
     * @param  array{period: Period, range: array<int, Carbon>}  $dates
     * @return array<int|string, array<string, int>>
     */
    protected function forClients(Collection $clients, array $dates): array
    {
        $streamIds = $clients->pluck('ga_stream_id')->filter();

        $analyticsData = Analytics::get(
            $dates['period'],
            ['activeUsers', 'screenPageViews'],
            ['streamId', 'date'],
            100000
        )->whereIn('streamId', $streamIds);

        return $this->transform($analyticsData, $clients, $dates['range']);
    }

    /**
     * @param  Collection<int, mixed>  $analyticsData
     * @param  Collection<int, \App\Models\Client>  $clients
     * @param  array<int, Carbon>  $range
     * @return array<int|string, array<string, int>>
     */
    protected function transform(Collection $analyticsData, Collection $clients, array $range): array
    {
        $daysTemplate = array_fill_keys(
            array_map(fn (Carbon $day) => $day->format('M d y'), $range),
            0
        );

        $grouped = $analyticsData
            ->map(function ($item) use ($clients) {
                $client = $clients->firstWhere('ga_stream_id', $item['streamId']);

                if (! $client) {
                    return null;
                }

                return collect([
                    'client_id' => $client->id,
                    'client_name' => $client->name,
                    'date' => $item['date']->format('M d y'),
                    'screenPageViews' => $item['screenPageViews'],
                ]);
            })
            ->filter()
            ->sortBy('date')
            ->groupBy('client_id');

        return $grouped->map(function (Collection $days) use ($daysTemplate) {
            $viewsByDate = $days->mapWithKeys(
                fn (Collection $item) => [$item['date'] => $item['screenPageViews']]
            )->all();

            return array_merge($daysTemplate, $viewsByDate);
        })->all();
    }
}
