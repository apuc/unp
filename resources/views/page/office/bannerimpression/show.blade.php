@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.bannerimpression.index')
			])

			@can('update', $bannerimpression)
				@include('control.office.toolbar.edit', [
					'url' => route('office.bannerimpression.edit', [
						'bannerimpression' => $bannerimpression->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $bannerimpression,
				'model'		=> \App\Bannerimpression::class,
				'groups'	=> [
					'properties' => [
						'bannerpost',
						'user',
						'impressed_at',
						'ip',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

