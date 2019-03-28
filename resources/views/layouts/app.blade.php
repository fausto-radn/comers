<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body>
    <div id="app">
      <navbar></navbar>
      <div class="my-4">
        @yield('content')

        <users></users>
      </div>



    </div>

    <script src="{{ asset('js/app.js') }}" charset="utf-8"></script>
  </body>
</html>