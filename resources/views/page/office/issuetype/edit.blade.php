@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.issuetype.show', $issuetype->id),
		'dataset'   => $issuetype,
		'model'     => \App\Issuetype::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
			],
		],
	])
@endsection
