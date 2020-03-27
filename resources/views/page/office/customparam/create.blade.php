@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.customparam.index'),
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

