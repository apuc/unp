@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.bookmaker.index'),
		'dataset'   => $bookmaker,
		'model'     => \App\Bookmaker::class,
		'groups'	=> [
			'properties' => [
				'name',
				'slug',
				'logo',
				'cover',
				'bonus',
				'announce',
				'description',
				'site',
				'phone',
				'email',
				'address',
				'external_id',
				'position',
				'is_enabled',
			],
			'seo' => [
				'seo_title',
				'seo_keywords',
				'seo_description',
			],
		],
	])
@endsection

