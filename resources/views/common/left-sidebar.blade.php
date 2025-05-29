
<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="{{ Request::path() == 'admin/dashboard' ? 'active' : '' }}">
                    <a href="{{url('/admin/dashboard')}}"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
                </li>
                
                <li class="{{ Request::path() == 'admin/leads' ? 'active' : '' }}{{ Request::path() == 'admin/new-user' ? 'active' : '' }}{{ Request::segment(2) == 'edit-user' ? 'active' : '' }}{{ Request::segment(2) == 'view-user' ? 'active' : '' }}">
                    <a href="{{url('/admin/leads')}}"><i class="menu-icon fa fa-users"></i>Leads </a>
                </li>
              
                
                <li class="{{ Request::segment(2) == 'products' ? 'active' : '' }}">
                    <a href="{{url('/admin/products')}}"><i class="menu-icon fa fa-lock"></i>Products </a>
                </li>
               
                
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside>