@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.sitepicture.index'),
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

