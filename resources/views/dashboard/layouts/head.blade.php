<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<title>@yield("title")</title>
<meta content="Admin Dashboard" name="description" />
<meta content="ThemeDesign" name="author" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<link href="{{URL::to('/')}}/templates/dashboard/assets/images/favicon.ico" rel="shortcut icon">
<link href="{{URL::to('/')}}/templates/dashboard/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="{{URL::to('/')}}/templates/dashboard/assets/css/icons.css" rel="stylesheet" type="text/css">
<link href="{{URL::to('/')}}/templates/dashboard/assets/css/style.css" rel="stylesheet" type="text/css">

<!-- Select2 -->
<link rel="stylesheet" href="{{URL::to('/')}}/templates/dashboard/assets/plugins/bootstrap-select2/select2.min.css" />
<link rel="stylesheet" href="{{URL::to('/')}}/templates/dashboard/assets/plugins/bootstrap-select2/select2-bootstrap.min.css">

<!-- SweetAlert 2 -->
<link href="{{URL::to('/')}}/templates/dashboard/assets/plugins/sweetalert2/sweetalert2.min.css" type="text/css" rel="stylesheet" />

<style type="text/css">
    .select2 {
        width: 100%;
    }

    .select2-container--default .select2-results__option--selected {
        background-color: #508aeb;
        color: white;
    }

    .select2-selection__rendered {
        line-height: calc(2.25rem + 2px) !important;
    }

    .select2-container .select2-selection--single {
        height: calc(2.25rem + 2px) !important;
    }

    .select2-selection__arrow {
        height: calc(2.25rem + 2px) !important;
    }

    .dropdown-toggle:after { content: none }

    table {
        width: 100%;
    }
</style>
@yield("css")
