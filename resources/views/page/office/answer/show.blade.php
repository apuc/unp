@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.answer.index')
			])

			@can('update', $answer)
				@include('control.office.toolbar.edit', [
					'url' => route('office.answer.edit', [
						'answer' => $answer->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $answer,
				'model'		=> \App\Answer::class,
				'groups'	=> [
					'properties' => [
						'issue',
						'posted_at',
						'user',
						'message',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

