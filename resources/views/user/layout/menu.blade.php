<div class="nav-container">
    <nav id="main-menu-navigation" class="navigation-main">
        {{-- <div class="nav-item {{ request()->routeIs(['user.dashboard']) ? 'active' : '' }}">
            <a href="{{ route('user.dashboard') }}"><i class="ik ik-bar-chart-2"></i><span>Dashboard</span></a>
        </div> --}}
        <div class="nav-lavel">Manage Site</div>
        <div class="nav-item has-sub {{ request()->routeIs('user.user-attendance.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="fa fa-calendar" aria-hidden="true"></i><span>Attendance</span> 
            </a>
            <div class="submenu-content">
                <a href="{{ route('user.user-attendance.index') }}" class="menu-item {{ request()->routeIs('user.user-attendance.index') ? 'active' : '' }}"><i class="ik file-text ik-file-text"></i>My Attendance</a>
            </div>
        </div>
        <div class="nav-item has-sub {{ request()->routeIs('user.leave.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik ik-check-circle"></i><span>Leave</span> 
            </a>
            <div class="submenu-content">
                <a href="{{ route('user.leave.create') }}" class="menu-item {{ request()->routeIs('user.leave.create') ? 'active' : '' }}"><i class="ik ik-plus-circle"></i>Add New Leave</a>
                <a href="{{ route('user.leave.index') }}" class="menu-item {{ request()->routeIs('user.leave.index') ? 'active' : '' }}"><i class="ik file-text ik-file-text"></i>List Of Leave</a>
            </div>
        </div>
        <div class="nav-item has-sub {{ request()->routeIs('user.user-deductions.*') ? 'active open' : '' }}">
            <a href="javascript:void(0)"><i class="ik file-minus ik-file-minus"></i><span>Deductions</span></a>
            <div class="submenu-content">
                <a href="{{ route('user.user-deductions.index') }}" class="menu-item {{ request()->routeIs('user.user-deductions.index') ? 'active' : '' }}"><i class="ik file-text ik-file-text"></i>List Of Deductions</a>
            </div>
        </div>
        <div class="nav-lavel">Site Settings</div>
        <div class="nav-item">    
            <a href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="ik log-out ik-log-out"></i><span>Logout</span>   
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
        
    </nav>
</div>