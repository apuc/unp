@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.noticetype.index')
			])

			@can('update', $noticetype)
				@include('control.office.toolbar.edit', [
					'url' => route('office.noticetype.edit', [
						'noticetype' => $noticetype->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $noticetype,
				'model'		=> \App\Noticetype::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
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
					'noticestatus',
					'user',
					'message',
				],
				'values'	=> [
					'noticetype_id' => $noticetype->id
				],
			])
		@endslot
	@endcomponent
@endsection

