<nav class="navbar navbar-expand-lg main-navbar">
    <ul class="navbar-nav mr-3 mr-auto">
        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
        <li><a href="{{route('home')}}" target="_blank" class="btn btn-dark">{{__('Go to website')}}</a></li>
    </ul>
    <ul class="navbar-nav navbar-right ml-auto">
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{asset(auth()->user()->avater)}}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">{{__('Hi')}}, {{auth()->user()->name}} </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{route('profile')}}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{__('Profile')}}
                </a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item has-icon text-danger" type="submit"> {{__('Logout')}}</button>
                </form>
            </div>
        </li>
    </ul>
</nav>