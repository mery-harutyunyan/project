<div class="profile-usermenu">
    <ul class="nav">
        <li class="{{(Route::getCurrentRoute()->getPath() == 'dashboard')?'active':''}}">
            <a href="/dashboard">
                <i class="glyphicon glyphicon-user"></i>
                Overview
            </a>
        </li>
        <li class="{{(Route::getCurrentRoute()->getPath() == 'orders')?'active':''}}">
            <a href="/orders">
                <i class="glyphicon glyphicon-list-alt"></i>
                Orders
            </a>
        </li>

    </ul>
</div>