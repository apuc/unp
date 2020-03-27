@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.deal.index'),
		'dataset'   => $deal,
		'model'     => \App\Deal::class,
		'groups'	=> [
			'properties' => [
				'name',
				'bookmaker',
				'dealtype',
				'url',
				'cover',
				'description',
			],
			'period' => [
				'started_at',
				'finished_at',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	])
@endsection

