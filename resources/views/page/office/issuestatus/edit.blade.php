@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.issuestatus.show', $issuestatus->id),
		'dataset'   => $issuestatus,
		'model'     => \App\Issuestatus::class,
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
