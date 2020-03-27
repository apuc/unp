@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.helpquestion.index'),
		'dataset'   => $helpquestion,
		'model'     => \App\Helpquestion::class,
		'groups'	=> [
			'properties' => [
				'helpsection',
				'name',
				'answer',
				'is_enabled',
			],
		],
	])
@endsection

