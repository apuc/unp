@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.customparam.index')
			])

			@can('update', $customparam)
				@include('control.office.toolbar.edit', [
					'url' => route('office.customparam.edit', [
						'customparam' => $customparam->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $customparam,
				'model'		=> \App\Customparam::class,
				'groups'	=> [
					'properties' => [
						'name',
						'slug',
						'customgroup',
						'customtype',
						'value_string',
						'value_integer',
						'value_float',
						'value_text',
						'value_boolean',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

