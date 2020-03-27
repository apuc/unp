@extends('layout.site.grid.double')

@section('content')
	<div class="article-detail">
		<time datetime="{{ $legaldocument->issued_at->format('Y-m-d') }}">@lang('message.site.legal.edition', ['issued_at' => Moment::asDate($legaldocument->issued_at)])</time>

		{!! $legaldocument->content !!}
    </div>
@endsection

@section('sidebar')
	@include('partial.site.sidebar.info', [
		'current' => 'site.legal.index'
	])
@endsection
