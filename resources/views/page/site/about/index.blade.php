@extends('layout.site.grid.double')

@section('content')
	@include('partial.site.texts', [
		'section' => $sitesection,
	])
@endsection

@section('sidebar')
	@include('partial.site.sidebar.info', [
		'current' => 'site.about.index'
	])
@endsection
