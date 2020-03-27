@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bannersection.index'),
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

