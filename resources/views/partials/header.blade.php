    <!-- Header Navbar -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">

            <ul class="navbar-nav">
                @yield('breadcrumb')
                {!! Admin::getNavbar()->render('left') !!}
            </ul>

            <ul class="navbar-nav  ms-auto">
                {!! Admin::getNavbar()->render() !!}
                <li class="nav-item">
                    <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                        <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen" style="display: block;"></i>
                        <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i>
                    </a>
                </li>
                <!-- User Account Menu -->
                <li class="nav-item dropdown user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ Admin::user()->avatar }}" class="user-image rounded-circle shadow"
                             alt="User Image">
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="d-none d-md-inline">{{ Admin::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header text-bg-primary">
                            <img src="{{ Admin::user()->avatar }}" class="rounded-circle shadow" alt="User Image">
                            <p>
                                {{ Admin::user()->name }}
                                <small>Member since admin {{ Admin::user()->created_at }}</small>
                            </p>
                        </li>
                        <li class="user-body">
                            <div class="float-start">
                                <a href="{{ admin_url('auth/setting') }}"
                                   class="btn btn-default btn-flat">{{ trans('admin.setting') }}</a>
                            </div>
                            <div class="float-end">
                                <a href="{{ admin_url('auth/logout') }}"
                                   class="btn btn-default btn-flat">{{ trans('admin.logout') }}</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                {{--<li>--}}
                {{--<a href="#" data-bs-toggle="control-sidebar"><i class="fa fa-gears"></i></a>--}}
                {{--</li>--}}
            </ul>
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-bs-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>


            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">

            </div>
        </div>
    </nav>
