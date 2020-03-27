@extends('layout.office.app')

@section('content')
	@component('control.office.screen.show')
		@slot('toolbar')
			@include('control.office.toolbar.back', [
				'url' => route('office.payment.index')
			])

			@can('update', $payment)
				@include('control.office.toolbar.edit', [
					'url' => route('office.payment.edit', [
						'payment' => $payment->id
					])
				])
			@endcan
		@endslot

		@slot('form')
			@include('control.office.plate.show', [
				'dataset'	=> $payment,
				'model'		=> \App\Payment::class,
				'groups'	=> [
					'properties' => [
						'user',
						'amount',
						'paid_at',
						'purpose',
					]
				],
			])
		@endslot
	@endcomponent
@endsection

