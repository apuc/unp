@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.role.index')
			])

			@can('update', $role)
				@include('control.office.toolbar.edit', [
					'url' => route('office.role.edit', [
						'role' => $role->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $role,
				'model'		=> \App\Role::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'users_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\User::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $users,
				'model'		=> \App\User::class,
				'fields'	=> [
					'login',
					'name',
					'avatar',
					'born_at',
					'email',
					'phone',
					'balance',
					'visited_at',
				],
				'values'	=> [
					'role_id' => $role->id
				],
			])
		@endslot
	@endcomponent
@endsection

