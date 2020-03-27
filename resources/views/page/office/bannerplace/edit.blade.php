@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.bannerplace.show', $bannerplace->id),
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
