<div id="main-wrapper">
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item "> <a class="nav-link nav-toggler  hidden-md-up  waves-effect waves-dark" href="javascript:void(0)"><i class="fas  fa-bars"></i></a></li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="fas fa-bars"></i></a> </li> 
                     <li class="nav-item mt-3">{{ Auth::user()->name_role }}</li>
					</ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item"><a href="{{url('/admin/onLogout')}}" class="btn btn-sm btn-danger">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="left-sidebar">
            <div class="scroll-sidebar">
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-devider mt-0" style="margin-bottom: 5px"></li>
                        <li> <a href="{{url('/dashboard')}}" ><span> <i class="fas fa-home"></i> </span><span class="hide-menu">Home</span></a></li>
                        <li> <a href="{{url('/project')}}" ><span> <i class="fas fa-list"></i> </span><span class="hide-menu">Project</span></a></li>
                    	<li> <a href="{{url('/task')}}" ><span> <i class="fas fa-tasks"></i> </span><span class="hide-menu">Task</span></a></li>
                        <li> <a href="{{url('/user_role')}}" ><span> <i class="fab fa-critical-role"></i> </span><span class="hide-menu">User's Role</span></a></li>
                        <li> <a href="{{url('/user')}}" ><span> <i class="fas fa-users"></i> </span><span class="hide-menu">Users</span></a></li>
                        <li> <a href="{{url('/assignment')}}" ><span> <i class="fas fa-clipboard"></i> </span><span class="hide-menu">Assignment</span></a></li>
					</ul>
                </nav>
            </div>
        </aside>
<div class="page-wrapper">
