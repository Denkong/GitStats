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

<!--
    <div class="flex-center position-ref full-height">
           

            <div class="content">
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
       
            <form method="POST" action="{{url('/savedata')}}">
                {!! csrf_field() !!}
                <div class="form-group">
                <label for="example-date-input">URL like: https://github.com/{username}/{reponame} https://github.com/Denkong/Laravel-React-Redux</label>
                
                    <input type="text" class="form-control" name="gitRepo" aria-describedby="emailHelp" placeholder="Git Repository">
                </div>

                <div class="form-group">
                    <label for="example-date-input">  Начало активности</label>
                    
                        <input class="form-control" type="date" name="dateStart">
                    
                </div>
                <div class="form-group">
                    <label for="example-date-input" >Конец активности</label>
                    
                        <input class="form-control" type="date" name="dateEnd">
                    
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
                    
        </div>
        
            @if (session('arrFiles'))
                    
                        
                        
                    <table class="table table-dark">
                        <thead>
                            <tr>
                            
                            <th scope="col"><a href="{{ action('indexController@sorted') }}">Название файла</a></th>
                            <th scope="col">Общее количество коммитов с изменениями данного файла</th>
                            <th scope="col">Список авторов, изменявших данный файл, с указанием количества коммитов</th>
                            </tr>
                        </thead>
                        <tbody>
                        
                        @foreach (session('arrFiles') as $key => $user)
                            <tr>
                            <td>{{$key}}</td>
                            <td>{{$user['totalCommitChange']}}</td>
                            <td>
                                @foreach($user['authors'] as $v)
                                    {{$v['name']}} - {{$v['changes']}}<br>
                                @endforeach
                            </td>
                            </tr>
                        @endforeach
                            
                        </tbody>
                    </table>
                
            @endif
            
        
        </div>
        -->