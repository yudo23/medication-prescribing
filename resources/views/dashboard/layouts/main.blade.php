<!DOCTYPE html>
<html lang="en">
    <head>
        {{-- Head --}}
        @include("dashboard.layouts.head")
        {{-- End Head --}}
    </head>


    <body class="fixed-left">

        @include('sweetalert::alert')

        <div id="wrapper">

            {{-- Sidebar --}}
            @include("dashboard.layouts.sidebar")
            {{-- End Sidebar --}}

            <div class="content-page">

                <div class="content">

                    {{-- Topbar --}}
                    @include("dashboard.layouts.topbar")
                    {{-- End Topbar --}}

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">

                            @if(session('error') || session('success'))
                            <div class="row">
                                <div class="col-12">
                                    @if (session('error'))
                                        @component('dashboard.components.alert')
                                            @slot("class")
                                                danger
                                            @endslot
                                            @slot("title")
                                                Gagal
                                            @endslot
                                            {!! session('error') !!}
                                        @endcomponent
                                    @elseif (session('success'))
                                        @component('dashboard.components.alert')
                                            @slot("class")
                                                success
                                            @endslot
                                            @slot("title")
                                                Berhasil
                                            @endslot
                                            {!! session('success') !!}
                                        @endcomponent
                                    @endif
                                </div>
                            </div>
                            @endif

                            @yield("breadcumb")

                            @yield("content")

                        </div>

                    </div>

                </div>

                {{-- Footer --}}
                @include("dashboard.layouts.footer")
                {{-- End Footer --}}

            </div>

        </div>

        @include("dashboard.components.preloader")

        {{-- Script --}}
        @include("dashboard.layouts.script")
        {{-- End Script --}}

    </body>
</html>