@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.outcomescope.index')
			])

			@can('update', $outcomescope)
				@include('control.office.toolbar.edit', [
					'url' => route('office.outcomescope.edit', [
						'outcomescope' => $outcomescope->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $outcomescope,
				'model'		=> \App\Outcomescope::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'description',
						'position',
						'is_enabled',
					],
					'external' => [
						'external_id',
						'external_name',
						'external_description',
					],
				],
			])
		@endslot
	@endcomponent
@endsection

