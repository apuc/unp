@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.posttournament.show', $posttournament->id),
		'dataset'   => $posttournament,
		'model'     => \App\Posttournament::class,
		'groups'	=> [
			'properties' => [
				'post',
				'tournament',
			],
		],
	])
@endsection
