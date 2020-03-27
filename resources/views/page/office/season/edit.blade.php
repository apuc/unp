@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.season.show', $season->id),
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
