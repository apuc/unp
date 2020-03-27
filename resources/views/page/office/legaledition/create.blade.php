@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.legaledition.index'),
		'dataset'   => $legaledition,
		'model'     => \App\Legaledition::class,
		'groups'	=> [
			'properties' => [
				'legaldocument',
				'issued_at',
				'content',
			],
		],
	])
@endsection