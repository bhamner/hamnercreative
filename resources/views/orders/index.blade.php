@extends('layouts.app')
@section('title') {{ config('app.name') }} - Invoices @stop
@section('content')

      @include('includes.response_alerts')



      @can('create', \App\Models\Order::class)
      <div class="text-end">
        <a class="btn btn-outline-primary my-4" href="{{ route('orders.edit') }}">
            Create a New Order
        </a>
      </div>
      @endcan

      <h2 class="text-md-start text-center">{{ $client->name }} — Invoices</h2>
      <p> Here you can view your past orders and invoices. <br/> The table is sortable, searchable, and you can download a csv of your current table view by clicking the csv button. <br/> If you dont see any orders, try changing the date selector in the top bar.</p>


      <div class="table-responsive mb-5 pb-3">
        <table class="table table-sm dataTable w-100" data-placeholder="No orders during this time period" data-search="true" data-paginate="true" data-col="0" data-dir="desc">
          <thead>
            <tr>
              <th scope="col">Date</th>
              @can('create', \App\Models\Order::class)<th scope="col">Client</th> @endcan
              <th scope="col">Name</th>
              <th scope="col">Invoice</th>
              <th scope="col">Status</th>
              @can('create', \App\Models\Order::class)<th scope="col">Actions</th>@endcan
            </tr>
          </thead>
          <tbody>
            @foreach( $orders as $order)
            <tr>
              <td class="text-nowrap" data-sort={{ strtotime($order->created_at) }}> {{ $order->created_at->format('M d Y') }}</td>
              @can('create', \App\Models\Order::class)
              <td> {{ $order->client->name }}</td>
              @endcan
              <td> {{ $order->name }}</td>
              <td> <a href="{{ route('invoices.show', $order) }}"> {{ $order->client->id }}-{{ $order->id }} </a></td>
              <td>
                  {{ $order->status }}
                  @can('update', $order)
                  @if( $order->status !== 'paid' )
                   <form method="POST" action="{{ route('orders.pay', $order) }}" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-outline-secondary mx-1" data-bs-toggle="tooltip" data-bs-title="mark as paid"
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;">
                        <i class="fa-solid fa-envelope-open-text"></i>
                      </button>
                   </form>
                  @endif
                  @endcan
              </td>
              @can('update', $order)
              <td data-sort={{ strtotime($order->created_at) }}>
                    <form method="POST" action="{{ route('orders.clone', $order) }}" class="d-inline">
                      @csrf
                      <button type="submit" class="btn btn-outline-primary mx-1" data-bs-toggle="tooltip" data-bs-title="clone"
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;">
                        <i class="fa fa-clone"></i>
                      </button>
                    </form>
                    <a class="btn btn-outline-secondary mx-1" data-bs-toggle="tooltip" data-bs-title="edit"
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;"
                              href="{{ route('orders.edit', $order) }}">
                        <i class="fa fa-edit"></i>
                    </a>
                    <form method="POST" action="{{ route('orders.delete', $order) }}" class="d-inline" onsubmit="return confirm('Are you sure?')">
                      @csrf
                      <button type="submit" class="btn btn-outline-danger mx-1" data-bs-toggle="tooltip" data-bs-title="delete"
                              style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .6rem;">
                        <i class="fa fa-times"></i>
                      </button>
                    </form>
              </td>
              @endcan
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

@endsection
