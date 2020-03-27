@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.noticestatus.index')
			])

			@can('update', $noticestatus)
				@include('control.office.toolbar.edit', [
					'url' => route('office.noticestatus.edit', [
						'noticestatus' => $noticestatus->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $noticestatus,
				'model'		=> \App\Noticestatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'notices_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Notice::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $notices,
				'model'		=> \App\Notice::class,
				'fields'	=> [
					'posted_at',
					'event',
					'noticetype',
					'user',
					'message',
				],
				'values'  	=> [
					'noticestatus_id' => $noticestatus->id
				],
			])
		@endslot
	@endcomponent
@endsection

