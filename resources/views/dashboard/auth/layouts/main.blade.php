<!DOCTYPE html>
<html lang="en">

<head>
    @include("dashboard.auth.layouts.head")
</head>


<body class="fixed-left">

    @include('sweetalert::alert')

    @yield("content")

    @include("dashboard.components.preloader")

    @include("dashboard.auth.layouts.script")

</body>

</html>