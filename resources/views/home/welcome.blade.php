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

      <div class="parallax-window active" id="header" data-parallax="scroll"
         data-image-src="{{ Vite::asset('resources/images/1bg.jpg') }}" >
         <div class="container">
            <div class="row">
              <div class="col-lg-12 col-xs-12">
               <!-- Navbar -->
               @include('home.navigation')
               <!-- Header Section -->
               @include('home.header')
              </div>   
            </div>
         </div>
      </div>

      <div class="main-wrapper">
         <!-- About Section -->
         @include('home.about')   
         <!-- Portfolio Section -->
         @include('home.portfolio')
         <!-- Contact Section -->
         @include('home.contact_form')
         <!-- Footer Section -->
        @include('home.footer')
      </div>
      
@endsection






