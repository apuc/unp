@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.dealtype.index')
			])

			@can('update', $dealtype)
				@include('control.office.toolbar.edit', [
					'url' => route('office.dealtype.edit', [
						'dealtype' => $dealtype->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $dealtype,
				'model'		=> \App\Dealtype::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
					],
					'statistics' => [
						'deals_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Deal::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $deals,
				'model'		=> \App\Deal::class,
				'fields'	=> [
					'name',
					'bookmaker',
					'cover',
					'started_at',
					'finished_at',
				],
				'values'	=> [
					'dealtype_id' => $dealtype->id
				],
			])
		@endslot
	@endcomponent
@endsection

