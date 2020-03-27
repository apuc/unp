<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ mix('/assets/office/css/app.css') }}">
    <script src="{{ mix('/assets/office/js/app.js') }}"></script>
    <script src="{{ asset('/assets/office/js/ckeditor/ckeditor.js') }}"></script>
</head>
<body>
<div class="wrapper">
    <header>
        <div class="container-fluid d-flex justify-content-start align-items-center">
            @include('partial.office.shell.header-logo')
            @include('partial.office.shell.sidebar-menu', ['first' => true])
            @include('partial.office.shell.sidebar-profile')
        </div>

        @include('partial.office.shell.sidebar-menu', ['first' => false])
    </header>
    <div class="content-wrapper">
        {!! Breadcrumbs::view('vendor/office/breadcrumbs/bootstrap4', $routeName, $parameters ?? []) !!}

        @include('partial.office.shell.alerts')

        <section class="content container-fluid">
            @include('partial.office.shell.content-title')
            @yield('content')
        </section>
    </div>

    <footer>
        <div class="container-fluid d-flex flex-column flex-sm-row justify-content-between">
            @include('partial.office.shell.footer-copyright')
        </div>
    </footer>

    @include('partial.office.shell.modal-editor', ['action' => 'tpl'])
</div>
</body>
</html><!-- {{ config('app.name') }} v{{ config('app.version') }} -->
