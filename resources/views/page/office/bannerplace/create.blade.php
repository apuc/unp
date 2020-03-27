@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bannerplace.index'),
		'dataset'   => $bannerplace,
		'model'     => \App\Bannerplace::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection

