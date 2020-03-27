@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.commentstatus.show', $commentstatus->id),
		'dataset'   => $commentstatus,
		'model'     => \App\Commentstatus::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'color_bg',
				'color_fg',
			],
		],
	])
@endsection
