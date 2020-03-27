@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.usersocial.show', $usersocial->id),
		'dataset'   => $usersocial,
		'model'     => \App\Usersocial::class,
		'groups'	=> [
			'properties' => [
				'user',
				'social',
				'account',
			],
		],
	])
@endsection
