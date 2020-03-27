@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.posttag.index')
			])

			@can('update', $posttag)
				@include('control.office.toolbar.edit', [
					'url' => route('office.posttag.edit', [
						'posttag' => $posttag->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $posttag,
				'model'		=> \App\Posttag::class,
				'groups'	=> [
					'properties' => [
						'post',
						'tag',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

