@extends('layout.site.app')

@section('columns')
	{!! Breadcrumbs::render($route, Crumb::params()) !!}

	<h1>{{ Crumb::caption() }}</h1>

	@hasSection('top')
		@yield('top')
	@endif

	<div class="row">
		<div class="content">
			@yield('content')
		</div>

		<div class="sidebar">
			@yield('sidebar')
			@includeWhen(config('show.banner.sidebar'), 'partial.site.bulletin.sidebar')
		</div>
	</div>

	@hasSection('bottom')
		@yield('bottom')
	@endif
@endsection