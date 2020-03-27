@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bookmakerpicture.index'),
		'dataset'   => $bookmakerpicture,
		'model'     => \App\Bookmakerpicture::class,
		'groups'	=> [
			'properties' => [
				'name',
				'bookmakertext',
				'picture',
			],
		],
	])
@endsection

