@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.outcomesubtype.index')
			])

			@can('update', $outcomesubtype)
				@include('control.office.toolbar.edit', [
					'url' => route('office.outcomesubtype.edit', [
						'outcomesubtype' => $outcomesubtype->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $outcomesubtype,
				'model'		=> \App\Outcomesubtype::class,
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

