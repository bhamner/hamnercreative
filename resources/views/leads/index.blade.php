@extends('layouts.app')
@section('title') {{ config('app.name') }} - Form Leads @stop
@section('content')

      @include('navigation.filters')
      @include('includes.response_alerts')
      
      <h2 class="text-md-start text-center">Form Generated Leads</h2> 
      <div class="table-responsive mb-5 pb-3">
        <table class="table dataTable w-100" data-placeholder="No leads generated during this time period" data-search="true" data-paginate="true" data-col="3" data-dir="desc">
          <thead>
            <tr>              
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Phone</th>
              <th scope="col">Last Entry</th>
            </tr>
          </thead>
          <tbody>
            @foreach($leads as $lead)
            <tr>
              <td> {{ $lead->name }}</td>
              <td> {{ $lead->email }}</td>
              <td> {{ $lead->phone }}</td>
              <td class="text-nowrap" data-sort={{ strtotime($lead->updated_at) }}> {{ $lead->updated_at->format('M d Y') }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>

@endsection