@extends('layout.site.grid.double')

@section('content')
    <div class="card card-detail">
    	<div class="card-header">
    		<span class="name"><a href="{{ route('site.bookmaker.index') }}">Букмекеры</a> / <a href="{{ route('site.bookmaker.show', ['bookmaker' => $bookmaker->slug]) }}">{{ $bookmaker->name }}</a></span>
    		{{--<span class="ic-other"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>--}}
		</div>
    	<div class="card-body">
    		<figure>
    			<img src="{{ asset('preview/782/274/storage/bookmakers/' . $bookmaker->cover) }}" alt="{{ $bookmaker->name }}" class="img-fluid">
			</figure>
			{!! $bookmaker->description !!}

    	</div>
	</div>

	@if ($bookmaker->deals->count())
		<div class="card-wrap">
   	   		<h2 class="title">Акции</h2>
			@foreach ($bookmaker->deals as $deal)
	            <div class="cards_list">
					@include('card.site.deal.normal', [
						'deal' => $deal,
					])
				</div>
			@endforeach
		</div>
	@endif
@endsection

@section('sidebar')
	@include('partial.site.sidebar.bookmaker')
@endsection
