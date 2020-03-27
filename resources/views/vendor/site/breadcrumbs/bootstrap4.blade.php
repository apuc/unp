@if ($breadcrumbs->slice(1, count($breadcrumbs) - 2)->count())
	<ol class="breadcrumb">
		@foreach ($breadcrumbs->slice(1, count($breadcrumbs) - 2) as $breadcrumb)
			<li class="breadcrumb-item"><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
		@endforeach
	</ol>
@endif
