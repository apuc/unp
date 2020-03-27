@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.forecastcomment.index'),
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

