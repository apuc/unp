@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.dealtype.show', $dealtype->id),
		'dataset'   => $dealtype,
		'model'     => \App\Dealtype::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection
