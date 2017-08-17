<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="{{URL::to('bootstrap/css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{URL::to('font-awesome/font-awesome.min.css')}}" rel="stylesheet">
    <link href="{{URL::to('css/style.css')}}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div class="container">
    
    @include('partials._header')
    
        <div id="content">
            @yield('content')
        </div>
        
    </div>
    <footer>
        <div class="footer"><strong>Designed by Stéphane gaudefroy.</strong></div>
    </footer>
    
    <script src="{{URL::to('jquery/jquery.js')}}"></script>
    <script src="{{URL::to('bootstrap/js/bootstrap.js')}}"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script type="text/javascript" src="/js/gestion.js"></script>
    @yield('scripts')
</body>
</html>
