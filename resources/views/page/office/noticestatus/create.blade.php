@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.noticestatus.index'),
		'dataset'   => $noticestatus,
		'model'     => \App\Noticestatus::class,
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

