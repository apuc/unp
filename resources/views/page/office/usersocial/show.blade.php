@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.usersocial.index')
			])

			@can('update', $usersocial)
				@include('control.office.toolbar.edit', [
					'url' => route('office.usersocial.edit', [
						'usersocial' => $usersocial->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $usersocial,
				'model'		=> \App\Usersocial::class,
				'groups'	=> [
					'properties' => [
						'user',
						'social',
						'account',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

