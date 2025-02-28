<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item">
                @if (auth()->user()->role->role == 'admin')
                    <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                        <i class="bi bi-list"></i>
                    </a>
                @endif
            </li>
            <li class="nav-item d-none d-md-block"><a href="{{ route('admin.home') }}" class="nav-link">Admin
                    Dashboard</a></li>
        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">

            <!--begin::Fullscreen Toggle-->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>
            <!--end::Fullscreen Toggle-->

            <!--begin::User Menu Dropdown-->
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <!-- Display profile picture if available, else show default picture -->
                    @php
                        $profilePicture = auth()->user()->media()->where('photo_type', 'profile_picture')->first();
                    @endphp

                    <img src="{{ $profilePicture ? asset($profilePicture->path) : asset('storage/uploads/profile_pictures/default_profile.jpg') }}"
                        alt="Profile Picture" class="rounded-circle" width="30" height="30">
                    <span class="d-none d-md-inline">{{ auth()->user()->name }} </span>
                </a>
                <ul class="dropdown-menu dropdown-menu dropdown-menu-end">
                    <!--begin::Menu Body-->
                    <li class="user-body">
                        <div class="text-center">{{ auth()->user()->name }}</div>
                    </li>
                    <!--end::Menu Body-->
                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('profile.show') }}" class="btn btn-default btn-flat">Profile</a>
                        <a class="btn btn-default btn-flat float-end" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    <!--end::Menu Footer-->
                </ul>
            </li>
            <!--end::User Menu Dropdown-->
        </ul>
        <!--end::End Navbar Links-->
    </div>
    <!--end::Container-->
</nav>
