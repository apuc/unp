@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.forecast.show', $forecast->id),
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
