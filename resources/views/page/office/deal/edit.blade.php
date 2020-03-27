@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.deal.show', $deal->id),
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
