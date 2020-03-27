@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.tournament.index'),
		'dataset'   => $tournament,
		'model'     => \App\Tournament::class,
		'groups'	=> [
			'properties' => [
				'name',
				'sport',
				'gender',
				'logo',
				'external_id',
				'tournamenttype',
				'position',
				'is_top',
			],
		],
	])
@endsection

