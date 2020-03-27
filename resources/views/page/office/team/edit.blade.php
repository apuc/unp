@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.team.show', $team->id),
		'dataset'   => $team,
		'model'     => \App\Team::class,
		'groups'	=> [
			'properties' => [
				'name',
				'sport',
				'country',
				'gender',
				'logo',
				'external_id',
			],
		],
	])
@endsection
