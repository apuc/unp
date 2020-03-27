@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.customparam.show', $customparam->id),
		'dataset'   => $customparam,
		'model'     => \App\Customparam::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'customgroup',
				'customtype',
				'value_string',
				'value_integer',
				'value_float',
				'value_text',
				'value_boolean',
			],
		],
	])
@endsection
