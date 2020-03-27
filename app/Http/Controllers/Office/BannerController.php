<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Banner\StoreRequest;
use App\Http\Requests\Office\Banner\UpdateRequest;

class BannerController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.banner.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Banner::class);

		$banners['rows'] = \App\Banner::query()
			->withRelations()
			->withCount('bannerposts')
			->sortBy(
				$banners['sort'] 		= $request->sort ?? 'name',
				$banners['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('banners'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$banner = \App\Banner::query()
			->withRelations()
			->withCount('bannerposts')
			->findOrFail($id);

		$this->authorize('read', $banner);

		$parameters['name'] = $banner->name;

		// Вложенные баннерные публикации
		if (auth()->user()->can('index', \App\Bannerpost::class))
			$bannerposts['rows'] = $banner->bannerposts()
				->withRelations()
				->sortBy(
					$bannerposts['sort']		= $request->sort ?? 'started_at',
					$bannerposts['direction'] 	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'banner'
		))
			->with('bannerposts',	$bannerposts ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$banner = new \App\Banner;

		$this->authorize('create', $banner);

		return view($this->view, compact('banner'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Banner\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$this->authorize('create', \App\Banner::class);

		$banner = \App\Banner::create($request->all());

		return response()->json([
			'status'	=> 'success',
			'id'		=> $banner->id,
			'name'		=> $banner->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BannerUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$banner = \App\Banner::query()
			->findOrFail($id);

		$this->authorize('update', $banner);

		$banner->fill($request->all());
		$banner->save();

		return response()->json(['status' => 'success'], 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function edit($id)
	{
		$banner = \App\Banner::query()
			->findOrFail($id);

		$this->authorize('read', $banner);

		$parameters['name'] = $banner->name;

		return view($this->view, compact(
			'parameters',
			'banner'
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$banner = \App\Banner::query()
			->findOrFail($id);

		$this->authorize('delete', $banner);

		$banner->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Banner::class);

		$banners = \App\Banner::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($banners as $banner)
			$answer[] = [
				'id'    => $banner->id,
				'value' => $banner->name,
			];

		return response()->json($answer, 200);
	}
}
