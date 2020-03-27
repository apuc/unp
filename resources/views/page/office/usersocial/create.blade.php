@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.usersocial.index'),
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

