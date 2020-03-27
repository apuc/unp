@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.user.show', $user->id),
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
