@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.tournamenttype.show', $tournamenttype->id),
		'dataset'   => $tournamenttype,
		'model'     => \App\Tournamenttype::class,
		'groups'	=> [
			'properties' => [
				'name',
				'sport',
			],
		],
	])
@endsection
