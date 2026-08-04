@extends('layouts.app')
@section('title') {{ config('app.name') }} - Metrics @stop
@section('content')

      <h2>{{ $client->name }} — Metrics</h2>
      <p> Here you can view your page views during selected time periods.  <sup>*</sup></p>
      
      @if( array_key_exists($client->id , $analytics) )
            <canvas id="line-chart"  
            data-labels="{{ json_encode( array_keys($analytics[ $client->id ]) )  }}"
            data-title = "Page views" 
            data-points = "{{ json_encode( $analytics[ $client->id ]  ) }}" 
            data-color= "{{ json_encode('rgba(130,188,0,0.5)') }}"
           ></canvas>
      @else
            <h5>There is no Analytics Data for your website during this time period.</h5>
      @endif
      <p class="py-5 text-black-50"><small> * Because our analytics have switched to use the new G4 tags, there will be no analytics data before August 2024 </small></p>
 

@endsection
