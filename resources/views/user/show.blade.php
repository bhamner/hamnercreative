@extends('layouts.app')
@section('title') Hamner Creative @stop
@section('content')

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"> </h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
              <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#deleteConfirmation">Delete your Account</button>
          </div>
        </div>
      </div>


      <h2>User Account </h2>
      <div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
      </div>
      <div>
        <div class="card mb-3" style="max-width: 540px;">
          <div class="row g-0">
            <div class="col-md-4">
               <img width="140px" src="{{ Auth::user()->avatar ? Auth::user()->avatar : Vite::asset('resources/images/hamnercreative_logo_black.png')  }}" class="img-fluid m-3" alt="avatar" referrerpolicy="no-referrer"> 
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <h5 class="card-title">{{ Auth::user()->name }}</h5>
                <p class="card-text">{{ Auth::user()->email }}</p>
                <p class="card-text"> Logged in with <i class="fa fa-google"></i> </p>
                <p class="card-text"><small class="text-body-secondary">Last Updated {{ Auth::user()->updated_at->diffForHumans() }}</small></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    @include('user.delete_confirmation_modal')
@endsection