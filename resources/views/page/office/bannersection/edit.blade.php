@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.bannersection.show', $bannersection->id),
		'dataset'   => $bannersection,
		'model'     => \App\Bannersection::class,
		'groups'	=> [
			'properties' => [
				'bannersection',
				'bannerplace',
				'sitesection',
			],
		],
	])
@endsection
