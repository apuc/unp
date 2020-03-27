@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.posttournament.index'),
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

