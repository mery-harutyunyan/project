<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Mery's project</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                @if (!Auth::user())
                    <li><a href="/auth/register">Register</a></li>
                    <li><a href="/auth/login">Login</a></li>
                @elseif(Auth::user() && Auth::user()->hasRole('user'))
                    <li class="{{(Route::getCurrentRoute()->getPath() == '/')?'active':''}}"><a href="/">Home</a></li>
                @endif
            </ul>

            @if (Auth::user())
                <ul class="nav navbar-nav navbar-right">
                    <li class="{{(Route::getCurrentRoute()->getPath() == 'cart')?'active':''}}">
                        <a href="/cart">
                            @if($cartCount)
                                <span class="cart-all-count label label-danger">{{$cartCount}}</span>
                            @endif
                            <span class="glyphicon glyphicon-shopping-cart " aria-hidden="true"></span>
                            Shopping cart
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                           aria-expanded="false">
                            {{Auth::user()->first_name.' '.Auth::user()->last_name}}
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="/dashboard">Dashboard</a></li>
                            <li><a href="/orders">Orders</a></li>

                            <li role="separator" class="divider"></li>
                            <li><a href="/auth/logout">Log out</a></li>
                        </ul>
                    </li>

                </ul>
            @endif
        </div>
    </div>
</nav>