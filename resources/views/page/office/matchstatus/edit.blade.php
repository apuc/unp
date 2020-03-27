@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.matchstatus.show', $matchstatus->id),
		'dataset'   => $matchstatus,
		'model'     => \App\Matchstatus::class,
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
