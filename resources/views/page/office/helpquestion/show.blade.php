@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.helpquestion.index')
			])

			@can('update', $helpquestion)
				@include('control.office.toolbar.edit', [
					'url' => route('office.helpquestion.edit', [
						'helpquestion' => $helpquestion->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $helpquestion,
				'model'		=> \App\Helpquestion::class,
				'groups'	=> [
					'properties' => [
						'helpsection',
						'name',
						'answer',
						'is_enabled',
					],
					'statistics' => [
						'helppictures_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Helppicture::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $helppictures,
				'model'		=> \App\Helppicture::class,
				'fields'	=> [
					'name',
					'picture',
				],
				'values'	=> [
					'helpquestion_id' => $helpquestion->id
				],
			])
		@endslot
	@endcomponent
@endsection

