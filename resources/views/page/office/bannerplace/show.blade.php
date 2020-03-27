@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bannerplace.index')
			])

			@can('update', $bannerplace)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bannerplace.edit', [
						'bannerplace' => $bannerplace->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bannerplace,
				'model'		=> \App\Bannerplace::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
					],
					'statistics' => [
						'bannerposts_count',
					]
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Bannerpost::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $bannerposts,
				'model'		=> \App\Bannerpost::class,
				'fields'	=> [
					'banner',
					'sitesection',
					'margin',
					'started_at',
					'finished_at',
					'view_limit',
					'view_amount',
					'click_limit',
					'click_amount',
					'is_enabled',
					'is_debug',
				],
				'values'	=> [
					'bannerplace_id' => $bannerplace->id
				],
			])
		@endslot
	@endcomponent
@endsection

