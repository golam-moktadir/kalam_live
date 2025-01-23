<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Samit Enterprise</title>
    <link href="{{asset('build/assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('build/assets/css/style.css')}}" rel="stylesheet">
    <script src="{{asset('build/assets/js/bootstrap.bundle.js')}}"></script>
  </head>
  <body>
    <div class="container-fluid mt-5">
      <div class="row justify-content-center">
        @yield('content')
      </div>
    </div>
  </body>
</html>