@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.sitesection.index')
			])

			@can('update', $sitesection)
				@include('control.office.toolbar.edit', [
					'url' => route('office.sitesection.edit', [
						'sitesection' => $sitesection->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $sitesection,
				'model'		=> \App\Sitesection::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
					'statistics' => [
						'sitetexts_count',
						'bannerposts_count',
					],
				],
			])
		@endslot

		@slot('tabs')
			@include('control.office.plate.nested-tab', [
				'model' => \App\Sitetext::class,
			])

			@include('control.office.plate.nested-tab', [
				'model' => \App\Bannerpost::class,
			])
		@endslot

		@slot('panels')
			@include('control.office.plate.nested-index', [
				'dataset' 	=> $sitetexts,
				'model'		=> \App\Sitetext::class,
				'fields'	=> [
					'name',
					'slug',
					'title',
					'picture',
					'is_enabled',
					'position',
					'sitepictures_count',
				],
				'values'	=> [
					'sitesection_id' => $sitesection->id
				],
			])

			@include('control.office.plate.nested-index', [
				'dataset' 	=> $bannerposts,
				'model'		=> \App\Bannerpost::class,
				'fields'	=> [
					'banner',
					'bannerplace',
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
					'sitesection_id' => $sitesection->id
				],
			])
		@endslot
	@endcomponent
@endsection

