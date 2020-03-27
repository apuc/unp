@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.issuetype.index')
			])

			@can('update', $issuetype)
				@include('control.office.toolbar.edit', [
					'url' => route('office.issuetype.edit', [
						'issuetype' => $issuetype->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $issuetype,
				'model'		=> \App\Issuetype::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
					],
					'statistics' => [
						'issues_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Issue::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $issues,
				'model'		=> \App\Issue::class,
				'fields'	=> [
					'posted_at',
					'user',
					'issuestatus',
					'author',
					'email',
					'message',
					'answers_count',
				],
				'values'	=> [
					'issuetype_id' => $issuetype->id
				],
			])
		@endslot
	@endcomponent
@endsection

