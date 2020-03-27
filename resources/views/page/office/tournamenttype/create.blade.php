@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.tournamenttype.index'),
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

