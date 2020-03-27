<!DOCTYPE html>
<html class="html-popup" lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>{{ Crumb::title() }}</title>
	<meta name="format-detection" content="telephone=no">
	<link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partial.site.metatags')
    <link rel="stylesheet" href="{{ mix('/assets/site/css/app.css') }}">
	<script src="{{ mix('/assets/site/js/app.js') }}"></script>
	@foreach($counters as $counter)
		{!! $counter->code_head !!}
	@endforeach
</head>
<body
	@if(config('show.banner.branding'))
		class="bg-branding-bulletin"
	@endif
>
	@foreach($counters as $counter)
		{!! $counter->code_top !!}
	@endforeach
	@includeWhen(config('show.banner.branding'), 'partial.site.bulletin.branding')
	<div class="wrap-container container">
		@include('partial.site.header')
		@includeWhen(config('show.banner.top'), 'partial.site.bulletin.top')
		<div class="page-content">
			@yield('columns')
			@includeWhen(config('show.banner.bottom'), 'partial.site.bulletin.bottom')
		</div>
		@include('partial.site.footer')
	</div>
	@include('partial.site.logon')
	@foreach($counters as $counter)
		{!! $counter->code_script !!}
	@endforeach
</body>
</html><!-- {{ config('app.name') }} v{{ config('app.version') }} -->