@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.payment.index'),
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

