<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @include('layouts.includes.meta')
    @include('layouts.includes.icons')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/sass/app.scss','resources/css/public.css'])
  </head>
  <body>
      @yield('content')
      @vite([ 'resources/js/app.js','resources/js/ui.js'])
  </body>
</html>