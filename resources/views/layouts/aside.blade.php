<!-- Menu -->

<aside id="layout-menu" class="layout-menu menu-vertical menu">

    <div class="app-brand demo ">
        <a href={{ route('dashboard') }} class="app-brand-link mt-2">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                            fill="currentColor" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                            fill="currentColor" />
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-3">Vuexy</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>
    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href={{ route('dashboard') }} class="menu-link">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div>
                    @lang('messages.home')
                </div>
            </a>
        </li>
        @can('viewAny', App\Models\Timekeeping::class)
            <li class="menu-item {{ request()->routeIs('timekeeping.*') ? 'active' : '' }}">
                <a href={{ route('timekeeping.index') }} class="menu-link">
                    <i class="menu-icon icon-base ti tabler-list-check"></i>
                    <div>
                        @lang('messages.timekeeping')
                    </div>
                </a>
            </li>
        @endcan

        @can('viewAny', App\Models\User::class)
            <li class="menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}" class="menu-link">
                    <i class="menu-icon icon-base ti tabler-user"></i>
                    <div>
                        @lang('messages.user-menu')
                    </div>
                </a>
            </li>
        @endcan
        @can('viewAny', App\Models\Roles::class)
            <li class="menu-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
                <a href={{ route('roles.index') }} class="menu-link">
                    <i class="menu-icon icon-base ti tabler-circles"></i>
                    <div>
                        @lang('messages.role-menu')
                    </div>
                </a>
            </li>
        @endcan
        @can('viewAny', App\Models\Position::class)
            <li class="menu-item {{ request()->routeIs('positions.*') ? 'active' : '' }}">
                <a href={{ route('positions.index') }} class="menu-link">
                    <i class="menu-icon icon-base ti tabler-user-pin"></i>
                    <div>
                        @lang('messages.position-menu')
                    </div>
                </a>
            </li>
        @endcan
        @can('viewAny', App\Models\Departments::class)
        <li class="menu-item {{ request()->routeIs('departments.*') ? 'active' : '' }}">
            <a href={{ route('departments.index') }} class="menu-link">
                <i class="menu-icon icon-base ti tabler-building"></i>
                <div>
                    @lang('messages.department-menu')
                </div>
            </a>
        </li>
        @endcan
        @can('viewAny', App\Models\Overtimes::class)

        <li class="menu-item {{ request()->routeIs('overtimes.*') ? 'active' : '' }}">
            <a href={{ route('overtimes.index') }} class="menu-link">
                <i class="menu-icon icon-base ti tabler-clock-plus"></i>
                <div>
                    @lang('messages.overtime-menu')
                </div>
            </a>
        </li>
        @endcan


        <li class="menu-item {{ request()->routeIs('day_offs.*') ? 'active' : '' }}

            {{ request()->routeIs('day_offs_user.*') ? 'active' : '' }}
            ">
            <a href={{ route('day_offs.index') }}  class="menu-link">
                <i class="menu-icon icon-base ti tabler-calendar-cancel"></i>
                <div>
                    @lang('messages.day_off-menu')
                </div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('kpi.*') ? 'active' : '' }}">
            <a href={{ route('kpi.index') }} class="menu-link">
                <i class="menu-icon icon-base ti tabler-cookie"></i>
                <div>
                    @lang('messages.kpi-menu')
                </div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('salary.*') ? 'active' : '' }}">
            <a href={{ route('salary.index') }} class="menu-link">
                <i class="menu-icon icon-base ti tabler-user-dollar"></i>
                <div>
                    @lang('messages.salary-menu')
                </div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('device.*') ? 'active' : '' }}">
            <a href="app-email.html" class="menu-link">
                <i class="menu-icon icon-base ti tabler-devices"></i>
                <div>Quản lý thiết bị</div>
            </a>
        </li>
    </ul>


</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large text-bg-secondary p-2 rounded-1">
        <i class="ti tabler-menu icon-base"></i>
        <i class="ti tabler-chevron-right icon-base"></i>
    </a>
</div>
<!-- / Menu -->
