<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <title>@yield('title')</title>

        <link rel="stylesheet" href="/css/bootstrap.min.css"  crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"  crossorigin="anonymous">
        <link rel="stylesheet" href="/css/dbetwallet.css?{{date('Ymdis')}}" media="screen">

        <script src="/js/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="/js/popper.min.js"  crossorigin="anonymous"></script>
        <script src="/js/bootbox.min.js" type="text/javascript"></script>
        <script src="/js/bootstrap.min.js"  crossorigin="anonymous"></script>

        @yield('style')

    </head>




    <body>
        
        <nav class="navbar navbar-dark bg-primary"><a class="navbar-brand" href="/wallet">DBET Wallet</a>

            <a href="/logout" style="float:right;color:#FFF">로그아웃</a>
        </nav>
    
        <div class="container">
            @yield('content')
        </div>

        @yield('script')
        <script>
        $(document).ready(function(){
            {{--

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

             --}}

            @if (Session::has('sweet_alert'))
                bootbox.alert("{{ Session::get('sweet_alert') }}");
            @endif

            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    var alert = '<div class="alert alert-danger">';
                    alert += '<a class="close" data-dismiss="alert" href="#">×</a>';
                    alert += '{{$error}}';
                    alert += '</div>';;

                    $("#errorMessage").append( alert );
                @endforeach

                $("#errorMessage").show();
            @endif

       });

    </script>
    </body>
</html>