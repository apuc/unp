@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.brieftournament.show', $brieftournament->id),
		'dataset'   => $brieftournament,
		'model'     => \App\Brieftournament::class,
		'groups'	=> [
			'properties' => [
				'brief',
				'tournament',
			],
		],
	])
@endsection
