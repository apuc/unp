@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.posttag.show', $posttag->id),
		'dataset'   => $posttag,
		'model'     => \App\Posttag::class,
		'groups'	=> [
			'properties' => [
				'post',
				'tag',
			],
		],
	])
@endsection
