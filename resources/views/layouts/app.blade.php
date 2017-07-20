<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <link rel="stylesheet" href="/build/css/app.css">



    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">@lang('app.home')</a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/index') }}">@lang('app.storage')</a></li>
                    @if(!Auth::guest())
                        <li><a href="{{ url('/users') }}">@lang('app.edit_account')</a></li>
                        @endif
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">@lang('app.login')</a></li>
                        <li><a href="{{ url('/register') }}">@lang('app.register')</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>@lang('app.logout')</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">

        @yield('content')

    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

    <script>
        $(document).ready(function() {
            //Удаление черной рамки на миниатюре
            $('div.image').click(function() {
                $bord = $('div.image').children(".bord");
                $bord.css("border"," 0px");
            });
            //Очищаем div справа и заполняем данными
            $( 'div.image' ).click(function() {
                $('.cont').empty();
                $(this).clone().appendTo('.cont');
                $id=$(this).children(".id").text();
                $public_link = $(this).children(".public_link").text();
                $uploaded = $(this).children(".uploaded").text();
                $token = $(this).children(".token").text();
                $bord = $(this).children(".bord");
                $bord.css("border"," 1px solid black");
                $a='Uploaded : '+ $uploaded + '<br><br>';
                $('.cont').append($a);
                $('.cont').append('<strong>Public URL : </strong>');
                if($public_link){
                    $a='<a href="'+$public_link+'">'+$public_link+'</a><br><br>';
                }else $a='<strong>No</strong><br><br>';
                $('.cont').append($a);
                $a='<a class="btn btn-primary " href="/download/'+$id+'">Download</a>';
                $('.cont').append($a);
                $a='<a class="btn btn-default " href="/share/'+$id+'">Share</a>';
                $('.cont').append($a);
                $a='<a class="btn btn-danger " href="/delete/'+$id+'">Delete</a> <br><br>';
                $('.cont').append($a);
                $a = '<form class="form-inline" action = "/rename/'+$id+'"  method = "POST" accept-charset="UTF-8" enctype="multipart/form-data">'+
                 '<input name="_token" type="hidden" value="'+ $token + '">  Rename:<br> <div class="form-group">  <input type="text" class="form-control" name="firstname"><br> ' +
                 ' </div><input type="submit" class="btn btn-default " value="Submit">  </div> </form>';
                $('.cont').append($a);
            });

        });



        $('div.alert').delay(5000).slideUp(300);


        $(function() {

            // We can attach the `fileselect` event to all file inputs on the page
            $(document).on('change', ':file', function() {
                var input = $(this),
                        numFiles = input.get(0).files ? input.get(0).files.length : 1,
                        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            // We can watch for our custom `fileselect` event like this
            $(document).ready( function() {
                $(':file').on('fileselect', function(event, numFiles, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                            log = numFiles > 1 ? numFiles + ' files selected' : label;

                    if( input.length ) {
                        input.val(log);
                    } else {
                        if( log ) alert(log);
                    }

                });
            });

        });

    </script>

<!-- Bootstrap tooltip-->
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.delete-user').click(function() {
                if (confirm("Вы уверены, что хотите удалить пользователя?"))
                {
                    window.location.href = "/user/delete";
                }
            });
        });
    </script>



</body>
</html>
