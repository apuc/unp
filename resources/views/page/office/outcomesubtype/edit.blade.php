@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.outcomesubtype.show', $outcomesubtype->id),
		'dataset'   => $outcomesubtype,
		'model'     => \App\Outcomesubtype::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'description',
				'position',
				'is_enabled',
			],
			'external' => [
				'external_id',
				'external_name',
				'external_description',
			],
		],
	])
@endsection
