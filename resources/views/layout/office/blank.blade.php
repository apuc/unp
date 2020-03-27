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
@yield('content')
</body>
</html><!-- {{ config('app.name') }} v{{ config('app.version') }} -->
