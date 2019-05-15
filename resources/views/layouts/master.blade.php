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
        
        <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
    <li class="nav-item dropdown">
      <a class="nav-item nav-link dropdown-toggle mr-md-2" href="#" id="bd-versions" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        v4.2
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="bd-versions">
        <a class="dropdown-item active" href="/docs/4.2/">Latest (4.2.x)</a>
        <a class="dropdown-item" href="https://getbootstrap.com/docs/4.1/">v4.1.3</a>
        <a class="dropdown-item" href="https://getbootstrap.com/docs/4.0/">v4.0.0</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="https://v4-alpha.getbootstrap.com/">v4 Alpha 6</a>
        <a class="dropdown-item" href="https://getbootstrap.com/docs/3.4/">v3.4.0</a>
        <a class="dropdown-item" href="https://getbootstrap.com/docs/3.3/">v3.3.7</a>
        <a class="dropdown-item" href="https://getbootstrap.com/2.3.2/">v2.3.2</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/docs/versions/">All versions</a>
      </div>
    </li>

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