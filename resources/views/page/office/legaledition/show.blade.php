@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.legaledition.index')
			])

			@can('update', $legaledition)
				@include('control.office.toolbar.edit', [
					'url' => route('office.legaledition.edit', [
						'legaledition' => $legaledition->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $legaledition,
				'model'		=> \App\Legaledition::class,
				'groups'	=> [
					'properties' => [
						'legaldocument',
						'issued_at',
						'content',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

