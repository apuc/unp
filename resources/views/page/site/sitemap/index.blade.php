@extends('layout.site.grid.double')

@section('content')
	<div class="card-wrap">
		<div class="sitemap">
			{!! Sitemap::render('vendor.site.sitemap.bootstrap4') !!}
		</div>
	</div>
@endsection