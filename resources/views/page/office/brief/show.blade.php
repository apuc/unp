@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.brief.index')
			])

			@can('update', $brief)
				@include('control.office.toolbar.edit', [
					'url' => route('office.brief.edit', [
						'brief' => $brief->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $brief,
				'model'		=> \App\Brief::class,
				'groups'	=> [
					'properties' => [
						'name',
						'sport',
						'user',
						'briefstatus',
						'picture',
						'picture_author',
						'announce',
						'content',
						'posted_at',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'briefcomments_count',
						'briefpictures_count',
						'brieftags_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Briefcomment::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Briefpicture::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Brieftag::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Brieftournament::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $briefcomments,
				'model'		=> \App\Briefcomment::class,
				'fields'	=> [
					'user',
					'commentstatus',
					'posted_at',
					'message',
				],
				'values'	=> [
					'brief_id' => $brief->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $briefpictures,
				'model'		=> \App\Briefpicture::class,
				'fields'	=> [
					'name',
					'picture',
				],
				'values'	=> [
					'brief_id' => $brief->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $brieftags,
				'model'		=> \App\Brieftag::class,
				'fields'	=> [
					'tag',
				],
				'values'	=> [
					'brief_id' => $brief->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $brieftournaments,
				'model'		=> \App\Brieftournament::class,
				'fields'	=> [
					'tournament',
				],
				'values'	=> [
					'brief_id' => $brief->id
				],
			])
		@endslot
	@endcomponent
@endsection

