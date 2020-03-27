@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.payment.show', $payment->id),
		'dataset'   => $payment,
		'model'     => \App\Payment::class,
		'groups'	=> [
			'properties' => [
				'user',
				'amount',
				'paid_at',
				'purpose',
			],
		],
	])
@endsection
