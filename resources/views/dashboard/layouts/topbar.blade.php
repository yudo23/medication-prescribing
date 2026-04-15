<div class="topbar">

    <div class="topbar-left	d-none d-lg-block">
        <div class="text-center">

            <a href="{{route('dashboard.index')}}" class="logo"><img src="{{URL::to('/')}}/templates/dashboard/assets/images/logo.png" height="20" alt="logo"></a>
        </div>
    </div>

    <nav class="navbar-custom">

        <ul class="list-inline float-right mb-0">

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-bell-outline noti-icon"></i>
                    <span class="badge badge-success badge-pill noti-icon-badge @if (Auth::user()->unreadNotifications->count() == 0) d-none @endif" id="notifBadge">{{ Auth::user()->unreadNotifications->count() }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-menu-lg">
                    <div class="dropdown-item noti-title">
                        <span class="badge badge-danger float-right" id="notifCount">{{ Auth::user()->unreadNotifications->count() > 0 ? Auth::user()->unreadNotifications->count() : null }}</span>
                        <h5>Notification</h5>
                    </div>

                    <div class="slimscroll" style="max-height: 230px;" id="notifList">
                        @if (Auth::user()->unreadNotifications->count() > 0)
                        @foreach (Auth::user()->unreadNotifications as $notification)
                        <a href="{{ route("dashboard.notification.read", $notification->id) }}" class="dropdown-item notify-item">
                            <div class="notify-icon bg-primary"><i class="mdi mdi-bell-ring"></i></div>
                            <p class="notify-details">
                                {!! $notification['data']['title'] !!}
                                <span class="text-muted">
                                    {!! $notification['data']['message'] !!}
                                </span>
                            </p>
                        </a>
                        @endforeach
                        @else
                        <span class="align-items-center d-flex dropdown-item h-100 justify-content-center notify-item" id="notifEmpty">Tidak terdapat notifikasi</span>
                        @endif
                    </div>

                    <a href="{{ route('dashboard.notification') }}" class="dropdown-item notify-all text-center">
                        Lihat Semua Notifikasi
                    </a>

                </div>
            </li>

            <li class="list-inline-item dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="@if(!empty(Auth::user()->avatar)) {{asset(Auth::user()->avatar)}} @else https://avatars.dicebear.com/api/initials/{{ Auth::user()->name  ?? null}}.svg?margin=10 @endif" alt="user" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown ">
                    <a class="dropdown-item active text-center" href="#" style="text-overflow: ellipsis; overflow: hidden;">{{ ucwords(Auth::user()->name) }}</a>
                    <a class="dropdown-item" href="{{route('dashboard.profile.index')}}"><i class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                    <a class="dropdown-item" href="{{route('dashboard.auth.logout')}}"><i class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="list-inline-item">
                <button type="button" class="button-menu-mobile open-left waves-effect">
                    <i class="ion-navicon"></i>
                </button>
            </li>
        </ul>

        <div class="clearfix"></div>

    </nav>

</div>
