@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.tag.index')
			])

			@can('update', $tag)
				@include('control.office.toolbar.edit', [
					'url' => route('office.tag.edit', [
						'tag' => $tag->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $tag,
				'model'		=> \App\Tag::class,
				'groups'	=> [
					'properties' => [
						'name',
					],
					'statistics' => [
						'posttags_count',
						'brieftags_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Posttag::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Brieftag::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $posttags,
				'model'		=> \App\Posttag::class,
				'fields'	=> [
					'post',
				],
				'values'	=> [
					'tag_id' => $tag->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $brieftags,
				'model'		=> \App\Brieftag::class,
				'fields'	=> [
					'brief',
				],
				'values'	=> [
					'tag_id' => $tag->id
				],
			])
		@endslot
	@endcomponent
@endsection

