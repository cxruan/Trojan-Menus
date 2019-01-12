<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Trojan Menus</title>

    <!-- Styles -->
    <link href="{{ asset('css/common.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css" rel="stylesheet">
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.2/dist/jquery.min.js"></script>
    <script src="https://s3-us-west-1.amazonaws.com/storage-cxruan/app.js"></script>

</head>

<body style="background-color: rgb(36,36,36);">
    <div id="wrapper">

        <style>
          @media only screen and (max-width: 600px) {
              #h1 {font-size: 13vw;}
              #h2 {font-size: 4vw;}
          }
          @media only screen and (min-width: 768px) {
              #h1 {font-size: 6vw;}
              #h2 {font-size: 1.7vw;}
          }
        </style>

        <div class="wrapper-content">
            <h2 id="h2" style="text-align: center;color: white">— Find your favorite food! —</h3>
            <h1 id="h1" style="text-align: center;color: white;font-weight: bold;">Trojan Menus</h1>
            <div class="arrow"><i class="fa fa-angle-double-down"></i></div>
        </div>
    </div>

    <!-- Content -->
    @yield('content')
    
    <div class="footer ">
        <div class="container">
            <div class="row footer-bottom">
                <ul class="list-inline text-center">
                    <li></li>
                </ul>
            </div>
        </div>
    </div>

</body>
</html>
