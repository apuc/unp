@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.deal.index')
			])

			@can('update', $deal)
				@include('control.office.toolbar.edit', [
					'url' => route('office.deal.edit', [
						'deal' => $deal->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $deal,
				'model'		=> \App\Deal::class,
				'groups'	=> [
					'properties' => [
						'name',
						'bookmaker',
						'dealtype',
						'url',
						'cover',
						'description',
					],
					'period' => [
						'started_at',
						'finished_at',
					],
					'seo' => [
						'seo_title',
						'seo_keywords',
						'seo_description',
					],
				],
			])
		@endslot
	@endcomponent
@endsection

