@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.edit', [
		'action'    => route('office.helpquestion.show', $helpquestion->id),
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
