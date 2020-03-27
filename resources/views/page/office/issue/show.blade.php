@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.issue.index')
			])

			@can('update', $issue)
				@include('control.office.toolbar.edit', [
					'url' => route('office.issue.edit', [
						'issue' => $issue->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $issue,
				'model'		=> \App\Issue::class,
				'groups'	=> [
					'properties' => [
						'id',
						'posted_at',
						'user',
						'issuetype',
						'issuestatus',
						'author',
						'email',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Answer::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $answers,
				'model'		=> \App\Answer::class,
				'fields'	=> [
					'id',
					'posted_at',
					'user',
					'message',
				],
				'values'	=> [
					'issue_id' => $issue->id
				],
			])
		@endslot

	@endcomponent
@endsection

