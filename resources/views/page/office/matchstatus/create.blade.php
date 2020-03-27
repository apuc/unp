@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.matchstatus.index'),
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

