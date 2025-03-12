<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('user.home') }}" class="nav-link">{{ __('app.dashboard') }} </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('posts.create') }}" class="nav-link">{{ __('Add Post') }}</a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('posts.myPosts') }}">{{ __('My Blog Posts') }}</a>
            </li>
            <li>
                <a class="nav-link" href="{{ route('posts.others') }}">{{ __('Others Blog Posts') }}</a>
            </li>

        </ul>
        <!--end::Start Navbar Links-->

        <!--begin::End Navbar Links-->
        <ul class="navbar-nav ms-auto">
            <!-- Language Dropdown -->
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="bi bi-globe"></i>
                    <span class="d-none d-md-inline">{{ __('app.language') }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a href="{{ route('language.switch', 'en') }}"
                            class="dropdown-item @if (app()->getLocale() == 'en') active @endif">
                            <span class="flag-icon flag-icon-us"></span>
                            English
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('language.switch', 'al') }}"
                            class="dropdown-item @if (app()->getLocale() == 'al') active @endif">
                            <span class="flag-icon flag-icon-al"></span>
                            Albanian
                        </a>
                    </li>
                </ul>
            </li>

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
                    @php
                        $profilePicture = auth()->user()->media()->where('photo_type', 'profile_picture')->first();
                    @endphp

                    <img src="{{ $profilePicture ? asset($profilePicture->path) : asset('storage/uploads/profile_pictures/default_profile.jpg') }}"
                        alt="{{ __('app.profile_picture') }}" class="rounded-circle" width="30" height="30">
                    <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu dropdown-menu-end">
                    <li class="user-body">
                        <div class="text-center">{{ auth()->user()->name }}</div>
                    </li>
                    <!--end::Menu Body-->

                    <!--begin::Menu Footer-->
                    <li class="user-footer">
                        <a href="{{ route('profile.show') }}"
                            class="btn btn-default btn-flat">{{ __('app.profile') }}</a>
                        <a class="btn btn-default btn-flat float-end" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('app.logout') }}
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
