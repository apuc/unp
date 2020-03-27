@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.counter.index'),
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

