@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.noticeban.index')
			])

			@can('update', $noticeban)
				@include('control.office.toolbar.edit', [
					'url' => route('office.noticeban.edit', [
						'noticeban' => $noticeban->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $noticeban,
				'model'		=> \App\Noticeban::class,
				'groups'	=> [
					'properties' => [
						'noticetype',
						'action',
						'user',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

