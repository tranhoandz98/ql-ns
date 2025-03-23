@php
    $user = Auth::user();
@endphp
<nav class="layout-navbar container-xxl navbar-detached navbar navbar-expand-xl align-items-center bg-navbar-theme"
    id="layout-navbar">
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
            <i class="icon-base ti tabler-menu-2 icon-md"></i>
        </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center justify-content-end" id="navbar-collapse">
        <!-- Search -->
        <div class="navbar-nav align-items-center">
            <div class="nav-item navbar-search-wrapper px-md-0 px-2 mb-0">
                <a class="nav-item nav-link search-toggler d-flex align-items-center px-0" href="javascript:void(0);">
                    <span class="d-inline-block text-body-secondary fw-normal" id="autocomplete"></span>
                </a>
            </div>
        </div>

        <!-- /Search -->

        <ul class="navbar-nav flex-row align-items-center ms-md-auto">
            <li class="nav-item dropdown-language dropdown">
                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                    href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="icon-base ti tabler-language icon-22px text-heading"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <form action="{{ route('change-lang') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="lang" value="vi">
                            <button type="submit"
                                class="dropdown-item {{ Session::get('locale') == 'vi' ? 'active' : '' }}"
                                data-language="vi" data-text-direction="ltr">
                                <span>
                                    @lang('messages.vietnam_lang')
                                </span>
                            </button>
                        </form>
                    </li>
                    <li>
                        <form action="{{ route('change-lang') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="lang" value="en">
                            <button type="submit"
                                class="dropdown-item {{ Session::get('locale') == 'en' ? 'active' : '' }}"
                                data-language="en" data-text-direction="ltr">
                                <span>
                                    @lang('messages.english_lang')
                                </span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
            <!-- Style Switcher -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill"
                    id="nav-theme" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="icon-base ti tabler-sun icon-22px theme-icon-active text-heading"></i>
                    <span class="d-none ms-2" id="nav-theme-text">Toggle theme</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="nav-theme-text">
                    <li>
                        <button type="button" class="dropdown-item align-items-center active"
                            data-bs-theme-value="light" aria-pressed="false">
                            <span><i class="icon-base ti tabler-sun icon-22px me-3" data-icon="sun"></i>Light</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="dark"
                            aria-pressed="true">
                            <span><i class="icon-base ti tabler-moon-stars icon-22px me-3"
                                    data-icon="moon-stars"></i>Dark</span>
                        </button>
                    </li>
                    <li>
                        <button type="button" class="dropdown-item align-items-center" data-bs-theme-value="system"
                            aria-pressed="false">
                            <span><i class="icon-base ti tabler-device-desktop-analytics icon-22px me-3"
                                    data-icon="device-desktop-analytics"></i>System</span>
                        </button>
                    </li>
                </ul>
            </li>
            <!-- / Style Switcher-->

            <!-- Notification -->
            <li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-2">
                <a class="nav-link dropdown-toggle hide-arrow btn btn-icon btn-text-secondary rounded-pill view-notify-list"
                    href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                    aria-expanded="false">
                    <span class="position-relative">
                        <i class="icon-base ti tabler-bell icon-22px text-heading"></i>
                        @if ($user->unread_notification)
                            <span class="badge rounded-pill  badge-notifications position-absolute ">
                                {{ $user->unread_notification }}
                            </span>
                        @endif
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end p-0">
                    <li class="dropdown-menu-header border-bottom">
                        <div class="dropdown-header d-flex align-items-center py-3">
                            <h6 class="mb-0 me-auto">
                                @lang('messages.notification')
                            </h6>
                            <div class="d-flex align-items-center h6 mb-0">
                                <span class="badge bg-label-primary me-2">
                                    {{ $user->unread_notification }}
                                    @lang('messages.notification-un_read')
                                </span>
                                <a href="javascript:void(0)" class="dropdown-notifications-all p-2 btn btn-icon"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Mark all as read"><i
                                        class="icon-base ti tabler-mail-opened text-heading"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown-notifications-list scrollable-container">
                        <ul class="list-group list-group-flush" id="list-notification">

                            {{-- <li class="list-group-item list-group-item-action dropdown-notifications-item">
                                <div class="d-flex">
                                    <a href="javascript:void(0);" class="w-100 d-flex">
                                  <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        av
                                    </div>
                                  </div>
                                  <div class="flex-grow-1">
                                    <h6 class="small mb-1">Congratulation Lettie 🎉</h6>
                                    <small class="mb-1 d-block text-body">Won the monthly best seller gold badge</small>
                                    <small class="text-body-secondary">1h ago</small>
                                  </div>
                                  <div class="flex-shrink-0 dropdown-notifications-actions">
                                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="icon-base ti tabler-x"></span></a>
                                  </div>
                                </a>
                                </div>
                            </li> --}}
                        </ul>
                    </li>
                    <li class="border-top" id="view-all-notify">
                        <div class="d-grid p-4">
                            <a class="btn btn-primary btn-sm d-flex" href={{route('notifications.index')}}>
                                <small class="align-middle">
                                    @lang('messages.notification-view_all')
                                </small>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>
            <!--/ Notification -->

            <!-- User -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/avatars/default.jpg') }}"
                            alt class="rounded-circle" />
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item mt-0" href={{ route('profile.edit') }}>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-2">
                                    <div class="avatar avatar-online">
                                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/avatars/default.jpg') }}"
                                            alt class="rounded-circle" />
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $user->name }}</h6>
                                    <small class="text-body-secondary">
                                        @php
                                            $TypeUserEnum = \App\Enums\User\TypeUserEnum::options();
                                            $statusBadge = '';
                                            $colorBadge = '';
                                            foreach ($TypeUserEnum as $type) {
                                                if ($type['id'] == $user->type) {
                                                    $statusBadge = $type['name'];
                                                    $colorBadge = $type['color'];
                                                    break;
                                                }
                                            }
                                        @endphp
                                        <span class="badge text-bg-{{ $colorBadge ?? 'secondary' }}">
                                            {{ $statusBadge }}
                                        </span>
                                    </small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider my-1 mx-n2"></div>
                    </li>
                    <li>
                    </li>

            </li>
            <li>
                <a class="dropdown-item" href={{ route('timekeeping.add-me') }}>
                    <i class="icon-base ti tabler-user-check me-3 icon-md"></i><span class="align-middle">
                        @lang('messages.timekeeping')
                    </span>
                </a>
            </li>
            <li>
                <a class="dropdown-item" href={{ route('profile.edit') }}>
                    <i class="icon-base ti tabler-user me-3 icon-md"></i><span class="align-middle">
                        @lang('messages.personal_information')
                    </span>
                </a>
            </li>

            <li>
                <a class="dropdown-item" href={{ route('password.change') }}>
                    <i class="icon-base ti tabler-password-user me-3 icon-md"></i><span class="align-middle">
                        @lang('messages.change_password')
                    </span>
                </a>
            </li>
            <li>
                <div class="d-grid px-2 pt-2 pb-1">
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="btn btn-sm btn-danger d-flex" href="route('logout')"
                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            <small class="align-middle">
                                @lang('messages.logout')
                            </small>
                            <i class="icon-base ti tabler-logout ms-2 icon-14px"></i>
                        </a>
                    </form>

                </div>
            </li>
        </ul>
        </li>
        <!--/ User -->
        </ul>
    </div>
    <script>
        document.querySelector('.view-notify-list').addEventListener('click', async function() {
            try {
                const response = await fetch('{{ route('notifications.listLimit') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                if (data) {
                    const listNotification = document.getElementById('list-notification');
                    const viewAllNotify = document.getElementById('view-all-notify');

                    // Clear existing notifications
                    listNotification.innerHTML = '';

                    if (data.length === 0) {
                        // Hide view all button if no notifications
                        viewAllNotify.style.display = 'none';

                        // Show empty message
                        listNotification.innerHTML = `
                        <li class="list-group-item list-group-item-action dropdown-notifications-item p-3 text-center">
                            <div class="text-muted">@lang('messages.no_notifications')</div>
                        </li>`;
                        return;
                    }

                    // Show view all button if there are notifications
                    viewAllNotify.style.display = 'block';

                    // Generate notification items
                    data.forEach(notification => {
                        const li = `
                        <li class="list-group-item list-group-item-action dropdown-notifications-item notify-item"
                        data-key="${notification.id}"
                        data-url="${notification.link ?? '#'}"
                        onclick="handleNotificationClick(event, '${notification.id}', '${notification.link ?? '#'}')"
                        style="cursor: pointer;"
                        >
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    <div class="avatar">
                                        <span class="avatar-initial rounded-circle bg-label-${notification.color ??'secondary'}">
                                            <span class="icon-base ti tabler-${(() => {
                                                const typeEnum = @json(\App\Enums\User\TypeNotifyReadEnum::options());
                                                const notificationType = typeEnum.find(item => item.id === notification.type);
                                                return notificationType ? notificationType.icon : notification.type;
                                            })()}"></span>
                                            </span>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 small">${notification.title}</h6>
                                    <small class="mb-1 d-block text-body">${notification.content}</small>
                                    <small class="text-body-secondary">${
                                        '{{ Session::get('locale', 'vi') }}' === 'vi'
                                        ? moment(notification.created_at).locale('vi').fromNow()
                                        : moment(notification.created_at).locale('en').fromNow()
                                    }</small>
                                </div>
                                <div class="flex-shrink-0 dropdown-notifications-actions">
                                    ${notification.is_read === 'UNREAD' ?
                                    `<a href="javascript:void(0)" class="dropdown-notifications-read"><span
                                                        class="badge badge-dot"></span></a>` : ''}
                                </div>
                            </div>
                        </li>
                        `;
                        listNotification.innerHTML += li;
                    });
                }
            } catch (error) {
                console.error('error: ', error);
            }
        });
    </script>
    <script>
       async function handleNotificationClick(event, notificationId, redirectUrl) {
            try {
                // Call the notification read API
                const response = await fetch(`{{ route('notifications.read', '') }}/${notificationId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                            .content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                });
                if (response.ok) {
                    // If API call is successful, redirect to the specified URL
                    window.location.href = redirectUrl;
                } else {
                    console.error('Failed to mark notification as read');
                }
            } catch (error) {
                console.error('Error:', error);
            }

        }
    </script>
</nav>
