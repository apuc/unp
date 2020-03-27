@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.sitetext.index')
			])

			@can('update', $sitetext)
				@include('control.office.toolbar.edit', [
					'url' => route('office.sitetext.edit', [
						'sitetext' => $sitetext->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $sitetext,
				'model'		=> \App\Sitetext::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'sitesection',
						'title',
						'picture',
						'announce',
						'content',
						'is_enabled',
						'position',
					],
					'statistics' => [
						'sitepictures_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Sitepicture::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $sitepictures,
				'model'		=> \App\Sitepicture::class,
				'fields'	=> [
					'name',
					'picture',
				],
				'values'	=> [
					'sitetext_id' => $sitetext->id
				],
			])
		@endslot
	@endcomponent
@endsection

