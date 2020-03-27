@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.social.index')
			])

			@can('update', $social)
				@include('control.office.toolbar.edit', [
					'url' => route('office.social.edit', [
						'social' => $social->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $social,
				'model'		=> \App\Social::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'site',
						'community',
						'icon',
					],
					'statistics' => [
						'usersocials_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Usersocial::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $usersocials,
				'model'		=> \App\Usersocial::class,
				'fields'	=> [
					'user',
					'account',
				],
				'values'	=> [
					'social_id' => $social->id
				],
			])
		@endslot
	@endcomponent
@endsection
