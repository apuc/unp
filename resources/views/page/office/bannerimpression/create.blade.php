@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bannerimpression.index'),
		'dataset'   => $bannerimpression,
		'model'     => \App\Bannerimpression::class,
		'groups'	=> [
			'properties' => [
				'bannerpost',
				'user',
				'impressed_at',
				'ip',
			],
		],
	])
@endsection

