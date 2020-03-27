@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.bookmakerpicture.show', $bookmakerpicture->id),
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
