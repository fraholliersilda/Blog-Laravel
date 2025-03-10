<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link-->
        <a href="#" class="brand-link">
            <!--begin::Brand Text-->
            <span class="brand-text fw-light"> {{ __('app.project') }}</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route ('admin.home')}}" class="nav-link ">
                        <i class="nav-icon bi bi-speedometer"></i>
                        <p>
                            {{ __('app.dashboard') }}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('alluser') }}" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>{{ __('app.all_users') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('users.index') }}" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>{{ __('app.all_users') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('api-keys.index') }}" class="nav-link ">
                        <i class="nav-icon bi bi-key"></i>
                        <p>API Keys</p>
                    </a>
                </li>
                {{-- @if (auth()->user()->role->name === 'admin')
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon bi bi-clipboard-fill"></i>
                        <p>
                            {{ __('app.post_management') }}
                            <span class="nav-badge badge text-bg-secondary me-3">6</span>
                            <i class="nav-arrow bi bi-chevron-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('allPost')}}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>{{ __('app.all_posts') }}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('addPostIndex')}}" class="nav-link">
                                <i class="nav-icon bi bi-circle"></i>
                                <p>{{ __('app.add_post') }}</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif --}}

            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
