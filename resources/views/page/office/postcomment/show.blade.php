@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.postcomment.index')
			])

			@can('update', $postcomment)
				@include('control.office.toolbar.edit', [
					'url' => route('office.postcomment.edit', [
						'postcomment' => $postcomment->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $postcomment,
				'model'		=> \App\Postcomment::class,
				'groups'	=> [
					'properties' => [
						'post',
						'user',
						'commentstatus',
						'posted_at',
						'message',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

