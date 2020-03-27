@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.forecast.index'),
		'dataset'   => $forecast,
		'model'     => \App\Forecast::class,
		'groups'	=> [
			'properties' => [
				'sport',
				'outcome',
				'bookmaker',
				'match',
				'user',
				'forecaststatus',
				'rate',
				'bet',
				'posted_at',
				'description',
			],
		],
	])
@endsection

