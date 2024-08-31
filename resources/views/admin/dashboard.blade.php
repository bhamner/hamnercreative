@extends('layouts.app')
@section('title') {{ config('app.name') }} - Dashboard @stop
@section('content')

      @include('navigation.filters')

      <h2>Welcome!</h2>
      <p> Here you can view your page views during selected time periods.  <sup>*</sup></p>
      
      @if( $client )
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
      @elseif( $analytics  )
            <canvas id="multi-line-chart"  
            data-labels="{{ json_encode(array_keys(array_values($analytics)[0]))}}"
            @php $i = 0 @endphp
            @foreach($analytics as $id => $values)
                  data-title-{{$i}} =  "{{ $clients->where('id',$id )->pluck('name')->first()  }}"
                  data-points-{{$i}} = "{{ json_encode(array_values($values)) }}" 
                  @php $i++ @endphp
            @endforeach
            data-total="{{ count($analytics) }}" 
            ></canvas>
      @else
            <p> No data during the selected time period </p>
      @endif
      <p class="py-5 text-black-50"><small> * Because our analytics have switched to use the new G4 tags, there will be no analytics data before August 2024 </small></p>
 

@endsection