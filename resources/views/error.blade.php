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
    </head>
    <body>
        
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            <a href="{{url('/test')}}">Вернуться назад</a>
        @endif
        
    </body>
</html>
