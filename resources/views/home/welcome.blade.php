@extends('layouts.home')
@section('title') {{ config('app.name') }} @stop
@section('content')

     <div class="preloader-wrap">
         <div class="preloader">
            <div class="lines">
               <div class="line line-1"></div>
               <div class="line line-2"></div>
               <div class="line line-3"></div>
            </div>
         </div>
      </div>

      <div class="parallax-window active hero-fullscreen" id="header" data-parallax="scroll"
         data-image-src="{{ Vite::asset('resources/images/1bg.jpg') }}" >
         <div class="container h-100">
            <div class="row h-100">
              <div class="col-lg-12 col-xs-12">
               @include('home.navigation')
               @include('home.header')
              </div>
            </div>
         </div>
         <div class="hero-footer">
            @include('home.footer')
         </div>
      </div>

@endsection
