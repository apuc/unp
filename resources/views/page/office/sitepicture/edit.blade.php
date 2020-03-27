@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.sitepicture.show', $sitepicture->id),
		'dataset'   => $sitepicture,
		'model'     => \App\Sitepicture::class,
		'groups'	=> [
			'properties' => [
				'name',
				'sitetext',
				'picture',
			],
		],
	])
@endsection
