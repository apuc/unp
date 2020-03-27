@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.role.index'),
		'dataset'   => $role,
		'model'     => \App\Role::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection

