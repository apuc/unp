@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.noticetemplate.index')
			])

			@can('update', $noticetemplate)
				@include('control.office.toolbar.edit', [
					'url' => route('office.noticetemplate.edit', [
						'noticetemplate' => $noticetemplate->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $noticetemplate,
				'model'		=> \App\Noticetemplate::class,
				'groups'	=> [
					'properties' => [
						'action',
						'noticetype',
						'role',
						'message',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

