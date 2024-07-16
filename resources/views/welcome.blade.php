@extends('layouts.public')
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
               @include('navigation.public')
               <!-- Header Section -->
               @include('components.public.header')
              </div>   
            </div>
         </div>
      </div>

      <div class="main-wrapper">
         <!-- About Section -->
         @include('components.public.about')   
         <!-- Portfolio Section -->
         @include('components.public.portfolio')
         <!-- Contact Section -->
         @include('components.public.contact_form')
         <!-- Footer Section -->
        @include('footer.public')
      </div>
      
@endsection






