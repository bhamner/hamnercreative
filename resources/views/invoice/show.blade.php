@extends('layouts.invoice')
@section('title') {{ config('app.name') }} - Invoice @stop
@section('content')

<div class="col-6 text-start">
    <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 319 359" height="64" width="72">
      <path d="M216.55,260.05c-19,10.97-38.03,21.93-57.04,32.9-19.02-10.98-38.04-21.93-57.04-32.9v-57.93h24.88v43.64l32.16,18.58,32.16-18.58v-34.31h24.89v48.6h0ZM164.91,12.78l-5.44-3.14-5.43,3.14-68.11,39.32L17.82,91.43l-5.46,3.15v169.81l5.5,3.18,68.08,39.3v.02s.14.09.14.09v-115.04h146.83v58.66l24.89-14.38V93.03l25.7,14.84v143.28l-61.96,35.77h-.04l-62.01,35.8-57.04-32.93v26.64l51.58,29.78,5.45,3.15,5.46-3.15,68.11-39.33v-.02s68.07-39.3,68.07-39.3l5.5-3.18V94.58l-5.46-3.15-68.11-39.33h-.04l-.1-.06v115.01H86.09v-58.65l-24.89,14.37v143.22l-25.7-14.84V107.87l62-35.8,62.02-35.81,57.03,32.93v-26.59l-51.64-29.81h0ZM102.46,156.87v-57.93c19.01-10.97,38.03-21.93,57.04-32.9,19.01,10.97,38.04,21.93,57.04,32.9v48.6h-24.89v-34.31l-32.16-18.58-32.16,18.58v43.63h-24.88Z" style="fill: #000; stroke-width: 0px;"/>
    </svg>
    <h1> Invoice </h1>
</div>
<div class="col-6 text-end">
   @include('invoice.includes.business_contact')
</div>
<hr/>
<div class="col-8 text-start">
    <p>
        Bill To: <br/>
        {{ $order->client->name }} <br/>
        {{ $order->client->address }}
    </p>
</div>
<div class="col-4 text-end">
    <p>
        Invoice: <br/>
         # {{ $order->client->id }}-{{ $order->id}} <br/>
        {{ $order->created_at->format('M d, Y') }}
    </p>
</div>
<hr/>
<div class="py-5">
    <table class="table table-striped ">
        <thead>
            <tr>
            <th scope="col">Service</th>
            <th scope="col">Quantity</th>
            <th scope="col">Rate</th>
            <th scope="col">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach( $order->services as $service )
            <tr>
            <th scope="row">{{ $service->name }}</th>
            <td>{{ $service->quantity }}</td>
            <td>${{ $service->rate }}</td>
            <td>${{ number_format( $service->quantity * $service->rate , 2 ) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="col-12 text-end">
    <h4>
        Total Due: ${{ number_format( $order->services()->sum(DB::Raw('quantity * rate')) ,2)  }}
    </h4>
</div>
<div class="py-5">
    @include('invoice.includes.invoice_disclaimer')
</div>
@endsection