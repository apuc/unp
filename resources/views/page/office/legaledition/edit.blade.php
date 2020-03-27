@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.legaledition.show', $legaledition->id),
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
