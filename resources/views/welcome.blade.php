<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>blog</title>
  <link rel="stylesheet" href="/css/all.css">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
       <title>Full stack</title>
    <script>
       (function () {
           window.Laravel ={
               csrfToken:'{{ csrf_token() }}'
           };
       })();
       
    </script>
    </head>
       <div id="app">
           @if(Auth::check())
           <mainapp :user="{{Auth::user()}}" :permission="{{Auth::user()->role->permission}}"></mainapp>
          @else
            <mainapp :user="false"></mainapp>
          @endif 
        </div>
    </body>
    <script src="{{mix('/js/app.js') }} " ></script>
</html>
