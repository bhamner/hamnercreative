<?php

namespace App\Logic;

use Carbon\Carbon;
use Illuminate\Support\Collection; 
use Request;
use Auth;

class AnalyticsTransformer 
{
   
    private static $instance;

    public static function getInstance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function setData($analyticsData): self
    {
        $clients = Auth::user()->clients; 
        $this->data = $analyticsData->transform(function($item) use ($clients){ 
            $client = $clients->where('ga_stream_id',$item["streamId"])->first();
                $item['client_id'] = $client->id;
                $item['client_name'] = $client->name;
                $item['date'] = $item['date']->format('M d y'); 
                return collect($item);
            })->sortBy('date')->groupBy('client_id');

        return $this;
     }

    

    public function build(): array
    {
        $days_array = array_fill_keys(array_map(function($item){ return $item->format('M d y') ;}, Request::get('dates')['range'] ), 0);
        return $this->data->map(function($days) use ($days_array) { 
            return array_merge($days_array,
                $days->flatMap(function($items){
                     $ret = []; $ret[$items['client_id']][$items['date']] = $items['screenPageViews']; return $ret;
                })->collapse()->toArray() );
            })->toArray();
    }
}