@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.counter.index')
			])

			@can('update', $counter)
				@include('control.office.toolbar.edit', [
					'url' => route('office.counter.edit', [
						'counter' => $counter->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $counter,
				'model'		=> \App\Counter::class,
				'groups'	=> [
					'properties' => [
						'name',
						'code_head',
						'code_top',
						'code_footer',
						'code_script',
						'is_enabled',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

