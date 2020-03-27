@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.forecastpicture.show', $forecastpicture->id),
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
