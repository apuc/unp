@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.issuestatus.index')
			])

			@can('update', $issuestatus)
				@include('control.office.toolbar.edit', [
					'url' => route('office.issuestatus.edit', [
						'issuestatus' => $issuestatus->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $issuestatus,
				'model'		=> \App\Issuestatus::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'color_bg',
						'color_fg',
					],
					'statistics' => [
						'issues_count',
					]
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
					'issuetype',
					'author',
					'email',
					'message',
					'answers_count',
				],
				'values'  	=> [
					'issuestatus_id' => $issuestatus->id
				],
			])
		@endslot
	@endcomponent
@endsection

