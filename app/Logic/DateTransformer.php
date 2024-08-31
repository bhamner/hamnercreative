<?php

namespace App\Logic;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Spatie\Analytics\Period;

class DateTransformer 
{
   
    private static $instance;

    private $date;

    public $default = 'this month';

    private $approved_dates;

    private $period;

    private $range;


    public static function getInstance(): self
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    public function setData($request): self
    {
        $this->data = $request->has('date') ? $request->get('date') : $this->default;
        $this->setApprovedDates()->setPeriod()->setRange();
        return $this;
     }

    public function setPeriod(): self
    {
        $dates = $this->approved_dates[ $this->data ];
        $limited_start_date = strtotime($dates[0]) < strtotime($dates[1].' -90 days') ?  strtotime($dates[1].' -90 days') : $dates[0];
        $this->period =  Period::create( Carbon::parse($limited_start_date) , Carbon::parse($dates[1]) );
        return $this;
    }

    public function setRange(): self
    {
        $dates = $this->approved_dates[ $this->data ];
        $limited_start_date = strtotime($dates[0]) < strtotime($dates[1].' -90 days') ?  strtotime($dates[1].' -90 days') : $dates[0];
        $period = CarbonPeriod::create( Carbon::parse($limited_start_date) , Carbon::parse($dates[1]) );
        $this->range = $period->toArray();
        return $this;
    }


    public function setApprovedDates(): self
    {
        $end = Carbon::yesterday()->toDateTimeString();
        $this->approved_dates =  [
            'last month' => [ Carbon::now()->subMonth(1)->startOfMonth()->toDateTimeString(), Carbon::now()->startOfMonth()->toDateTimeString() ],
            'this month' => [ Carbon::now()->startOfMonth()->toDateTimeString(), $end ],
            'this year' =>  [ Carbon::now()->startOfYear()->toDateTimeString(), $end ],
            'last year' =>  [ Carbon::now()->subYears(1)->startOfYear()->toDateTimeString(),Carbon::now()->startOfYear()->toDateTimeString() ],
            'all time' =>   [ Carbon::now()->startOfCentury()->toDateTimeString(), $end ]
        ];
        return $this;
    }

    public function build(): array 
    {
        return [ 
                'params' => $this->approved_dates[ $this->data ], 
                'period' => $this->period,
                'selected' =>  $this->data, 
                'range' => $this->range,
                'options' => array_keys( $this->approved_dates )
            ];
    }
}