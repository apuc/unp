@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.season.index'),
		'dataset'   => $season,
		'model'     => \App\Season::class,
		'groups'	=> [
			'properties' => [
				'tournament',
				'name',
				'external_id',
			],
		],
	])
@endsection

