@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.team.index'),
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

