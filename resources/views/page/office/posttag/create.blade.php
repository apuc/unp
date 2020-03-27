@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.posttag.index'),
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

