<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" type="text/css">
       
        <link rel="stylesheet" href="{{ asset('css/style.css') }}"> 
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        
            <div id="example"></div>
            <script src="{{asset('js/app.js')}}" ></script>
    </body>
</html>

