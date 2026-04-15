@extends("dashboard.layouts.main")

@section("title","Notifikasi")

@section("breadcumb")
<div class="row">
    <div class="col-sm-12">
        <div class="float-right page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                <li class="breadcrumb-item active">Notifikasi</li>
            </ol>
        </div>
        <h5 class="page-title">Notifikasi</h5>
    </div>
</div>
@endsection

@section("content")
<div class="row">
    <div class="col-md-12">
        <div class="card m-b-30 px-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="">Daftar Notifikasi</h4>
                    </div>
                    @if ($unread > 0)
                    <div class="col-md-6 text-right">
                        <a href="{{ route("dashboard.notification.markAsRead") }}" class="btn btn-primary btn-sm">Tandai Sudah
                            Baca</a>
                    </div>
                    @endif
                </div>
                @if ($notifications->count() > 0)
                <ul class="my-3 list-unstyled activity-list">
                    @foreach ($notifications as $key => $notification)
                    <li class="activity-item">
                        <span class="activity-date">
                            {{ Carbon\Carbon::parse($notification->created_at)->format("d M y") }} <br>
                            {{ Carbon\Carbon::parse($notification->created_at)->format("H:i:s") }}
                        </span>
                        @if (empty($notification->read_at))
                        <span class="badge badge-danger float-right py-1 px-3">BARU</span>
                        @endif
                        <span class="activity-text">
                            <a href="{{ route("dashboard.notification.read", $notification->id) }}">
                                {!! $notification->data['title'] !!}
                            </a>
                        </span>
                        <p class="text-muted mt-2">{!! $notification->data['message'] !!}</p>
                    </li>
                    @endforeach
                </ul>
                <div>
                    {!! $notifications->links() !!}
                </div>
                @else
                <h5 class="text-center">Tidak terdapat notifikasi</h5>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection