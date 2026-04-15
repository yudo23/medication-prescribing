@extends("dashboard.auth.layouts.main")

@section("title","Login")

@section("css")
@endsection

@section("content")
<!-- Begin page -->
<div class="accountbg">

    <div class="content-center">
        <div class="content-desc-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-8">
                        <div class="card">
                            <div class="card-body">

                                @include("dashboard.auth.layouts.logo")

                                <h4 class="text-muted text-center font-18"><b>Sign In</b></h4>

                                <div class="p-2">
                                    <form class="form-horizontal m-t-20" method="post" action="{{route('dashboard.auth.login.post')}}">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="text" placeholder="Username" name="username" value="{{old('username')}}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-12">
                                                <input class="form-control" type="password" placeholder="Password" name="password" required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-6">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="rememberme" value="1">
                                                    <label class="custom-control-label" for="customCheck1">Ingat saya</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group text-center row m-t-20">
                                            <div class="col-12">
                                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- end row -->
            </div>
        </div>
    </div>
</div>
@endsection