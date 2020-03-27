@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.bannerimpression.show', $bannerimpression->id),
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
