@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.brieftournament.index'),
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

