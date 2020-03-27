@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.briefstatus.index')
			])

			@can('update', $briefstatus)
				@include('control.office.toolbar.edit', [
					'url' => route('office.briefstatus.edit', [
						'briefstatus' => $briefstatus->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $briefstatus,
				'model'		=> \App\Briefstatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'briefs_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Brief::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $briefs,
				'model'		=> \App\Brief::class,
				'fields'	=> [
					'name',
					'sport',
					'user',
					'picture',
					'posted_at',
					'briefcomments_count',
					'briefpictures_count',
				],
				'values'  	=> [
					'briefstatus_id' => $briefstatus->id
				],
			])
		@endslot
	@endcomponent
@endsection

