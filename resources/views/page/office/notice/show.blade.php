@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.notice.index')
			])

			@can('update', $notice)
				@include('control.office.toolbar.edit', [
					'url' => route('office.notice.edit', [
						'notice' => $notice->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $notice,
				'model'		=> \App\Notice::class,
				'groups'	=> [
					'properties' => [
						'posted_at',
						'event',
						'noticetype',
						'noticestatus',
						'user',
						'message',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

