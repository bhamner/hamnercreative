@extends('layouts.app')
@section('title') {{ config('app.name') }} - Orders @stop
@section('content')

      @include('navigation.filters')
      @include('includes.response_alerts')
      
      
      @if( $gate->allowed() ) 
      <div class="text-end">
        <a class="btn btn-outline-primary my-4" href="/order/edit">
            Create a New Order
        </a>
      </div>
      @endif
     
      <h2 class="text-md-start text-center">Orders</h2> 
      <p> Here you can view your past orders and invoices. <br/> The table is sortable, searchable, and you can download a csv of your current table view by clicking the csv button. <br/> If you dont see any orders, try changing the date selector above.</p>
      </p>

      <div class="table-responsive mb-5 pb-3">
        <table class="table table-sm dataTable w-100" data-placeholder="No orders during this time period" data-search="true" data-paginate="true" data-col="0" data-dir="desc">
          <thead>
            <tr>
              <th scope="col">Date</th>
              @if( $gate->allowed() )<th scope="col">Client</th> @endif
              <th scope="col">Name</th>
              <th scope="col">Invoice</th>
              <th scope="col">Status</th>
              @if( $gate->allowed() )<th scope="col">Actions</th>@endif
            </tr>
          </thead>
          <tbody>
            @foreach( $orders as $order)
            <tr>
              <td class="text-nowrap" data-sort={{ strtotime($order->created_at) }}> {{ $order->created_at->format('M d Y') }}</td>
              @if( $gate->allowed() )
              <td> {{ $order->client->name }}</td>
              @endif
              <td> {{ $order->name }}</td>
              <td> <a href="/invoice/{{ $order->id }}"> {{ $order->client->id }}-{{ $order->id }} </a></td>
              <td> 
                  {{ $order->status }} 
                  @if( $order->status !== 'paid' && $gate->allowed() ) 
                   <a class="btn btn-outline-secondary mx-1"  data-bs-toggle="tooltip" data-bs-title="mark as paid" 
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;" 
                              href="/order/pay/{{ $order->id }}">
                        <i class="fa-solid fa-envelope-open-text"></i>
                    </a>
                  @endif
              </td>
              @if( $gate->allowed() )
              <td data-sort={{ strtotime($order->created_at) }}>
                    <a class="btn btn-outline-primary mx-1"  data-bs-toggle="tooltip" data-bs-title="clone"
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;" 
                              href="/order/clone/{{ $order->id }}">
                        <i class="fa fa-clone"></i>
                    </a>
                    <a class="btn btn-outline-secondary mx-1"  data-bs-toggle="tooltip" data-bs-title="edit"
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;" 
                              href="/order/edit/{{ $order->id }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-outline-danger mx-1"  data-bs-toggle="tooltip" data-bs-title="delete"
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;" 
                              href="/order/delete/{{ $order->id }}" onclick="return confirm('Are you sure?')">
                        <i class="fa fa-times"></i>
                    </a>
              </td>
              @endif
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

@endsection