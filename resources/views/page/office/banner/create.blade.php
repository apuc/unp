@extends('layout.office.blank')

@section('content')
	@include('control.office.plate.create', [
		'action'    => route('office.banner.index'),
		'dataset'   => $banner,
		'model'     => \App\Banner::class,
		'groups'	=> [
			'properties' => [
				'name',
				'bannerformat',
				'bannercampaign',
				'picture',
				'link',
				'html',
				'alt',
			],
		],
	])
@endsection

