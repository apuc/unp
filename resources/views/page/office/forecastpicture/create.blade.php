@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.forecastpicture.index'),
		'dataset'   => $forecastpicture,
		'model'     => \App\Forecastpicture::class,
		'groups'	=> [
			'properties' => [
				'name',
				'forecast',
				'picture',
			],
		],
	])
@endsection

