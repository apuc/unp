@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.banner.index')
			])

			@can('update', $banner)
				@include('control.office.toolbar.edit', [
					'url' => route('office.banner.edit', [
						'banner' => $banner->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $banner,
				'model'		=> \App\Banner::class,
				'groups'	=> [
					'properties' => [
						'name',
						'bannerformat',
						'bannercampaign',
						'picture',
						'link',
						'html',
						'alt',
					],
					'statistics' => [
						'bannerposts_count',
					],
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
					'sitesection',
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
					'banner_id' => $banner->id
				],
			])
		@endslot

	@endcomponent
@endsection

