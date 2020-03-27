@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.forecaststatus.show', $forecaststatus->id),
		'dataset'   => $forecaststatus,
		'model'     => \App\Forecaststatus::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'color_bg',
				'color_fg',
			],
		],
	])
@endsection
