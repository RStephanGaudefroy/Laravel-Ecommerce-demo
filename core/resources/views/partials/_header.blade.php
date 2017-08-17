<nav class="navbar navbar-default" id="header">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div id="hamburger" class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      
      <ul class="nav navbar-nav navbar-left">
        <li>
            <a class="navbar-brand" href="{{ route('product.index') }}"><i class="fa fa-home fa-2x" aria-hidden="true"></i></a>
        </li>
        <li id="header-title">
            @yield('view')    
        </li>
      </ul>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="{{ route('product.cartview') }}">
                    <i class="fa fa-shopping-basket" aria-hidden="true"></i>&nbsp Mon panier
                    <!--@if (Session::has('cart'))-->
                        <span class="badge">
                            <!--{{ Session::get('cart')->totalQty }}-->
                            {{ Session::has('cart') ? Session::get('cart')->totalQty : '' }}
                        </span>
                    <!--@endif-->
                </a>
            </li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i>    
                    @if (Route::has('login'))
                        @if (Auth::check())
                            {{ Auth::user()->name }}
                            <span class="caret"></span>
                            <ul class="dropdown-menu">
                                @if (Auth::user()->profil == '1')
                                    <li><a href="{{route('control.gestionArticle') }}">Gest. Article</a></li>
                                @endif
                                <li><a href="{{ route('user.profile') }}">Mon profil</a></li>
                                <li role="separator" class="divider"></li>
                                <li><a href="{{route('contact.pageContact') }}">Contact</a></li>  
                                <li role="separator" class="divider"></li>
                                <li><a href="{{ route('user.logout') }}">Déconnexion</a></li>
                            </ul>           
                        @else
                            Utilisateur<span class="caret"></span>
                            <ul class="dropdown-menu">
                                <li><a href="{{ url('/login') }}">Login</a></li>
                                <li><a href="{{ url('/register') }}">Register</a></li>    
                            </ul>           
                        @endif
                    @endif
                </a>     
            </li>
        </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>