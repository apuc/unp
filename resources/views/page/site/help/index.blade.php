@extends('layout.site.grid.double')

@section('content')
    <div class="card-wrap">
    	<h2 class="title">Разделы справки</h2>
		@if ($helpsections->count())
    		<div class="row category-list">
    			@foreach ($helpsections as $helpsection)
    				<div class="col-12 col-md-4 category-list__item">
            			<div class="card">
            				<div class="card-body">
            					<a href="{{ route('site.help.section', ['section' => $helpsection->slug]) }}">
            						<img src="{{ asset('preview/96/96/storage/helpsections/' . $helpsection->icon) }}" alt="{{ $helpsection->name }}" class="img-fluid">
            						<h3>{{ $helpsection->name }}</h3>
								</a>
            				</div>
            			</div>
					</div>
				@endforeach
			</div>
		@else
			<p>Информация для раздела подготавливается</p>
		@endif
	</div>
@endsection

@section('top')
	@if (filled($document = Text::get($sitesection, 'top')))
	   	<section class="text-top">
			{!! $document->content !!}
	   	</section>
	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.info', [
		'current' => 'site.help.index'
	])
@endsection

@section('bottom')
	@if (filled($document = Text::get($sitesection, 'bottom')))
	   	<section class="text-bottom">
			{!! $document->content !!}
	   	</section>
	@endif
@endsection

