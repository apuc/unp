@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.forecastcomment.show', $forecastcomment->id),
		'dataset'   => $forecastcomment,
		'model'     => \App\Forecastcomment::class,
		'groups'	=> [
			'properties' => [
				'forecast',
				'user',
				'commentstatus',
				'posted_at',
				'message',
			],
		],
	])
@endsection
