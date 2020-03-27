@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.poststatus.index')
			])

			@can('update', $poststatus)
				@include('control.office.toolbar.edit', [
					'url' => route('office.poststatus.edit', [
						'poststatus' => $poststatus->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $poststatus,
				'model'		=> \App\Poststatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'posts_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Post::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $posts,
				'model'		=> \App\Post::class,
				'fields'	=> [
					'name',
					'sport',
					'user',
					'picture',
					'posted_at',
					'postcomments_count',
					'postpictures_count',
				],
				'values'  	=> [
					'poststatus_id' => $poststatus->id
				],
			])
		@endslot
	@endcomponent
@endsection

