
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
                    <li class="{{(Route::getCurrentRoute()->getPath() == 'dashboard')?'active':''}}"><a href="/dashboard">Dashboard</a></li>
                    <li class="{{(Route::getCurrentRoute()->getPath() == 'shop')?'active':''}}"><a href="/shop">Shop</a></li>
                @endif
            </ul>

            @if (Auth::user())
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/auth/logout">Log out</a></li>
                </ul>
            @endif
        </div>
    </div>
</nav>