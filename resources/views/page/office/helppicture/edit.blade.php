@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.helppicture.show', $helppicture->id),
		'dataset'   => $helppicture,
		'model'     => \App\Helppicture::class,
		'groups'	=> [
			'properties' => [
				'helpquestion',
				'name',
				'picture',
			],
		],
	])
@endsection
