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
    <main>
      <section class="py-5 text-center container">
        <div class="row px-lg-5">
          <!-- page content -->
          @yield('content')
        </div>
      </section>
    </main>
  </body>
</html>