@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.user.index'),
		'dataset'   => $user,
		'model'     => \App\User::class,
		'groups'	=> [
			'properties' => [
				'login',
				'name',
				'avatar',
				'role',
				'born_at',
				'about',
				'password',
				'password_confirmation',
				'email',
				'phone',
			],
		],
	])
@endsection

