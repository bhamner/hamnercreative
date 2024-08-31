@extends('layouts.app')
@section('title') {{ config('app.name') }} - Content @stop
@section('content')

      @include('navigation.filters')
      @include('includes.response_alerts')
      
      @if( $request->get('client') )
      <div class="text-end my-4">
         <a class="btn btn-outline-primary" href="/content/{{ $request->get('client')->id }}/edit">
            Create a New Item
        </a>
      </div>
      @endif
      <h2 class="text-md-start text-center">Website Content</h2> 
      <div class="table-responsive mb-5 pb-3">
        <table class="table dataTable w-100" data-placeholder="No content" data-search="true" data-paginate="true" data-col="0" data-dir="asc">
          <thead>
            <tr>              
              <th scope="col">Name</th>
              <th scope="col">Description</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col">In stock?</th>
              <th scope="col">Last Edited</th>
            </tr>
          </thead>
          <tbody>
            @foreach($content as $item)
            <tr class="clickable-row" data-href="/content/{{ $item->client->id }}/edit/{{ $item->id }}">
              <td> {{ $item->name }}</td>
              <td> {{  strlen($item->description) > 50 ? substr($item->description,0,50).'...' : $item->description }}</td>
              <td> {{ $item->quantity_available }}</td>
              <td> ${{ number_format($item->price,2) }}</td>
              <td class="text-center" data-sort="{{ $item->in_stock }}"> 
                <i class="fa-regular {{ $item->in_stock ?'fa-circle-check text-success':'fa-circle-xmark text-danger' }}"></i>
              </td>
              <td class="text-nowrap" data-sort={{ strtotime($item->updated_at) }}> {{ $item->updated_at->format('M d Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

@endsection