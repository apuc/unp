@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.helppicture.index'),
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

