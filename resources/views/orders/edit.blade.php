@extends('layouts.app')
@section('title') {{ config('app.name') }} - Edit Order @stop
@section('content')

<div class="py-5">

      @include('includes.response_alerts')

      <h2>{{ $order ? 'Edit Order': 'New Order' }}</h2>
     
      <form method="POST" action="/order/update" class="form">
            @csrf
            @if( $order ) <input type="hidden" name="order_id" value="{{ $order->id }}" /> @endif
            <div class="row g-3 px-5 py-3">
                  <div class="col-12">
                        <label for="title_input" class="form-label">Title</label>
                        <input type="text" class="form-control @if($errors->has('order_title')) is-invalid @endif" id="title_input" name="order_title" placeholder="Web Design" 
                        @if( $order ) value="{{ $order->name }}" @endif required/>
                  </div>

                  <div class="col-md-6">
                        <label for="client_select" class="form-label">Client</label>
                        <select id="client_select" name="order_client" class="form-select select2" required> 
                        @foreach( $clients as $opt )
                              <option value="{{ $opt->id }}" @if( $order && $order->client->id == $opt->id) selected @endif> {{ $opt->name }}</option>
                        @endforeach
                        </select>
                  </div>
                  <div class="col-md-6">
                        <label for="status_select" class="form-label">Status</label>
                        <select id="status_select" name="order_status" class="form-select select2" required>
                        @foreach( [ 'open','paid' ] as $opt )
                              <option value="{{ $opt }}" @if( $order && $order->client->status == $opt) selected @endif> {{ $opt }}</option>
                        @endforeach
                        </select>
                  </div>
            </div>
            <div id="service-div" class="g-3 px-5 py-3">
                  @if( $order && $order->services )
                  @foreach( $order->services as $service )
                  <div class="row g-3 py-2 border border-opacity-10 pb-4 my-2">
                        <div class="col-md-1">
                              <div class="d-grid gap-2">
                              <button class="btn btn-link delete-parent-row" style="margin-top:30px">
                                    <i class="fa fa-times"></i>
                                    <span class="d-block d-md-none"> Delete Service </span>
                              </button>
                              </div>
                        </div>
                        <div class="col-md-7">
                              <label for="service_name_input" class="form-label">Item</label>
                              <input value="{{ $service->name }}" type="text" class="form-control" name="service_name[]" placeholder="Website Design"/>
                        </div>
                        <div class="col-md-2">
                              <label for="service_rate_input" class="form-label">Rate</label>
                              <div class="input-group">
                               <span class="input-group-text">$</span>
                               <input value="{{ $service->rate }}"  class="form-control" name="service_rate[]" placeholder="100"  type="number" min="0.01" step="0.01" max="2500" >
                              </div>
                        </div>
                        <div class="col-md-2">
                               <label for="service_quantity_input" class="form-label">Quantity</label>
                               <input value="{{ $service->quantity }}" type="number" min="1" max="10000"  class="form-control" name="service_quantity[]" placeholder="1"/>
                        </div>
                  </div>
                  @endforeach
                  @endif
                  <div class="row g-3 py-2 border border-opacity-10 pb-4 my-2">
                        <div class="col-md-1">
                              <div class="d-grid gap-2">
                              <button class="btn btn-link delete-parent-row" style="margin-top:30px">
                                    <i class="fa fa-times"></i>
                                    <span class="d-block d-md-none"> Delete Service </span>
                              </button>
                              </div>
                        </div>
                        <div class="col-md-7">
                              <label for="service_name_input" class="form-label">Item</label>
                              <input type="text" class="form-control" name="service_name[]" placeholder="Website Design"/>
                        </div>
                        <div class="col-md-2">
                              <label for="service_rate_input" class="form-label">Rate</label>
                              <div class="input-group">
                               <span class="input-group-text">$</span>
                               <input class="form-control"  name="service_rate[]" placeholder="100"
                               type="number" min="0.01" step="0.01" max="2500" >
                              </div>
                        </div>
                        <div class="col-md-2">
                               <label for="service_quantity_input" class="form-label">Quantity</label>
                               <input type="number" min="1" max="10000" class="form-control" name="service_quantity[]" placeholder="1"/>
                        </div>
                  </div>
            </div>
           
            <div class="row g3 px-5 py-5">
                  <div class="d-grid gap-2">
                      <button type="submit" class="btn btn-outline-primary">Submit</button>
                  </div>
            </div>
      </form>
</div>

@endsection