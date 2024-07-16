<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/sass/app.scss','resources/css/app.css'])
  </head>
  <body>
    <!--- register svgs -->
    @include('svgs.admin')
    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6 text-white" href="/dashboard">
        <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 319 359" height="32" width="36">
          <path d="M216.55,260.05c-19,10.97-38.03,21.93-57.04,32.9-19.02-10.98-38.04-21.93-57.04-32.9v-57.93h24.88v43.64l32.16,18.58,32.16-18.58v-34.31h24.89v48.6h0ZM164.91,12.78l-5.44-3.14-5.43,3.14-68.11,39.32L17.82,91.43l-5.46,3.15v169.81l5.5,3.18,68.08,39.3v.02s.14.09.14.09v-115.04h146.83v58.66l24.89-14.38V93.03l25.7,14.84v143.28l-61.96,35.77h-.04l-62.01,35.8-57.04-32.93v26.64l51.58,29.78,5.45,3.15,5.46-3.15,68.11-39.33v-.02s68.07-39.3,68.07-39.3l5.5-3.18V94.58l-5.46-3.15-68.11-39.33h-.04l-.1-.06v115.01H86.09v-58.65l-24.89,14.37v143.22l-25.7-14.84V107.87l62-35.8,62.02-35.81,57.03,32.93v-26.59l-51.64-29.81h0ZM102.46,156.87v-57.93c19.01-10.97,38.03-21.93,57.04-32.9,19.01,10.97,38.04,21.93,57.04,32.9v48.6h-24.89v-34.31l-32.16-18.58-32.16,18.58v43.63h-24.88Z" style="fill: #fff; stroke-width: 0px;"/>
        </svg>
      </a>
      <ul class="navbar-nav flex-row d-md-none">
        <li class="nav-item text-nowrap">
          <button class="nav-link px-3 text-white" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <svg class="bi"><use xlink:href="#list"></use></svg>
          </button>
        </li>
      </ul>
    </header>
    <div class="container-fluid">
      <div class="row">
        <!-- sidebar navigation -->
        @include('navigation.app')
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
          <!-- page content -->
          @yield('content')
        </main>
      </div>
    </div>
    @vite([ 'resources/js/app.js','resources/js/app_ui.js'])
  </body>
</html>