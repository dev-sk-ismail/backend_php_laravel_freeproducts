<header id="header" class="header">
    <div class="top-left">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{url('/admin/dashboard')}}"><img src="{{asset('back_end/images/logo.png')}}" alt="Logo"></a>
            <a class="navbar-brand hidden" href="{{url('/admin/dashboard')}}"><img src="{{asset('back_end/images/logo2.png')}}" alt="Logo"></a>
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
            <div class="header-left">
                
            </div>

            <div class="user-area dropdown float-right">
                <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <img class="user-avatar rounded-circle" src="{{asset('back_end/images/avatar/avatar.png')}}" alt="User Avatar">  
                </a>

                <div class="user-menu dropdown-menu">
                    <a class="nav-link" href="{{url('/admin/logout')}}"><i class="fa fa-power-off"></i>Logout</a>
                </div>
            </div>

        </div>
    </div>
</header>