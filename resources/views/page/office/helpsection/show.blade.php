@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.helpsection.index')
			])

			@can('update', $helpsection)
				@include('control.office.toolbar.edit', [
					'url' => route('office.helpsection.edit', [
						'helpsection' => $helpsection->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $helpsection,
				'model'		=> \App\Helpsection::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'icon',
						'announce',
						'text_header',
						'text_footer',
						'is_enabled',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'helpquestions_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Helpquestion::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $helpquestions,
				'model'		=> \App\Helpquestion::class,
				'fields'	=> [
					'name',
					'helpsection',
					'is_enabled',
					'helppictures_count',
				],
				'values'	=> [
					'helpsection_id' => $helpsection->id
				],
			])
		@endslot

	@endcomponent
@endsection

