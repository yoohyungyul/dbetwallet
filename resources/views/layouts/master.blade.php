<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <title>@yield('title')</title>

        <!-- <link rel="stylesheet" href="/css/bootstrap.min.css"  crossorigin="anonymous"> -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"  crossorigin="anonymous">
        <link rel="stylesheet" href="/css/dbetwallet.css?{{date('Ymdis')}}" media="screen">

        <script src="/js/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="/js/popper.min.js"  crossorigin="anonymous"></script>
        <script src="/js/bootstrap.min.js"  crossorigin="anonymous"></script>

        @yield('style')

    </head>




    <body>
        
        <nav class="navbar navbar-dark bg-primary"><a class="navbar-brand" href="/wallet">DBET Wallet</a></nav>
    
        <div class="container">
            @yield('content')
        </div>

        @yield('script')
    </body>
</html>