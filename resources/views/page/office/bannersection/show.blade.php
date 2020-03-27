@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bannersection.index')
			])

			@can('update', $bannersection)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bannersection.edit', [
						'bannersection' => $bannersection->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bannersection,
				'model'		=> \App\Bannersection::class,
				'groups'	=> [
					'properties' => [
						'bannersection',
						'bannerplace',
						'sitesection',
					],
					'statistics' => [
						'bannersections_count',
						'bannerposts_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Bannersection::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Bannerpost::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $bannersections,
				'model'		=> \App\Bannersection::class,
				'fields'	=> [
					'bannerplace',
					'sitesection',
					'bannersections_count',
					'bannerposts_count',
				],
				'values'	=> [
					'bannersection_id' => $bannersection->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $bannerposts,
				'model'		=> \App\Bannerpost::class,
				'fields'	=> [
					'banner',
					'impressions',
					'started_at',
					'finished_at',
					'bannerimpressions_count',
				],
				'values'	=> [
					'bannersection_id' => $bannersection->id
				],
			])
		@endslot
	@endcomponent
@endsection

