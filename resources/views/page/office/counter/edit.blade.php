@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.counter.show', $counter->id),
		'dataset'   => $counter,
		'model'     => \App\Counter::class,
		'groups'	=> [
			'properties' => [
				'name',
				'code_head',
				'code_top',
				'code_footer',
				'code_script',
				'is_enabled',
			],
		],
	])
@endsection
