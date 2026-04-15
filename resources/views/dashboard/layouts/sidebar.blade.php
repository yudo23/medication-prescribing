<div class="left side-menu">
    <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
        <i class="ion-close"></i>
    </button>

    <div class="left-side-logo d-block d-lg-none">
        <div class="text-center">

            <a href="{{route('dashboard.index')}}" class="logo"><img src="{{URL::to('/')}}/templates/dashboard/assets/images/logo-dark.png" height="20" alt="logo"></a>
        </div>
    </div>

    <div class="sidebar-inner slimscrollleft">

        <div id="sidebar-menu">
            <ul>
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{route('dashboard.index')}}" class="waves-effect">
                        <i class="fa fa-tachometer"></i>
                        <span> Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('dashboard.patient-records.index')}}" class="waves-effect">
                        <i class="fa fa-heartbeat"></i>
                        <span> Pemeriksaan Pasien</span>
                    </a>
                </li>   

                <li>
                    <a href="{{route('dashboard.users.index')}}" class="waves-effect">
                        <i class="fa fa-users"></i>
                        <span> Pengguna</span>
                    </a>
                </li>                

                @if(Auth::user()->hasRole([\App\Enums\RoleEnum::ADMINISTRATOR]))
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cog"></i> <span> Pengaturan </span> <span class="menu-arrow float-right"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('dashboard.log-users.index')}}">Log Pengguna</a></li>
                    </ul>
                </li>
                @endif
            </ul>
        </div>
        <div class="clearfix"></div>
    </div> <!-- end sidebarinner -->
</div>