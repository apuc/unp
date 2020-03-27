@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.commentstatus.index')
			])

			@can('update', $commentstatus)
				@include('control.office.toolbar.edit', [
					'url' => route('office.commentstatus.edit', [
						'commentstatus' => $commentstatus->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $commentstatus,
				'model'		=> \App\Commentstatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'postcomments_count',
						'briefcomments_count',
						'forecastcomments_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Postcomment::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Briefcomment::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Forecastcomment::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $postcomments,
				'model'		=> \App\Postcomment::class,
				'fields'	=> [
					'post',
					'user',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'commentstatus_id' => $commentstatus->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $briefcomments,
				'model'		=> \App\Briefcomment::class,
				'fields'	=> [
					'brief',
					'user',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'commentstatus_id' => $commentstatus->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $forecastcomments,
				'model'		=> \App\Forecastcomment::class,
				'fields'	=> [
					'forecast',
					'user',
					'posted_at',
					'message',
				],
				'values'  	=> [
					'commentstatus_id' => $commentstatus->id
				],
			])
		@endslot
	@endcomponent
@endsection

