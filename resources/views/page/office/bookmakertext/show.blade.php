@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bookmakertext.index')
			])

			@can('update', $bookmakertext)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bookmakertext.edit', [
						'bookmakertext' => $bookmakertext->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bookmakertext,
				'model'		=> \App\Bookmakertext::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'bookmaker',
						'picture',
						'announce',
						'content',
						'is_enabled',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'bookmakerpictures_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Bookmakerpicture::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $bookmakerpictures,
				'model'		=> \App\Bookmakerpicture::class,
				'fields'	=> [
					'name',
					'picture',
				],
				'values'	=> [
					'bookmakertext_id' => $bookmakertext->id
				],
			])
		@endslot
	@endcomponent
@endsection

