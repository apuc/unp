@extends('layout.site.grid.double')

@section('content')
    <div class="card-wrap">
    	<h2 class="title">Документы</h2>

		@if ($legaldocuments->count())
			@foreach ($legaldocuments as $legaldocument)	
				@include('card.site.legal.normal', [
					'slug' 		=> $legaldocument->slug,
					'name' 		=> $legaldocument->name,
					'issued_at' => $legaldocument->issued_at,
				])
			@endforeach
		@else
			<p>Документы не найдены</p>
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
   		'current' => 'site.legal.index'
   	])
@endsection

@section('bottom')
	@if (filled($document = Text::get($sitesection, 'bottom')))
	   	<section class="text-bottom">
			{!! $document->content !!}
	   	</section>
	@endif
@endsection
