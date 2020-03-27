<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bannerformat\StoreRequest;
use App\Http\Requests\Office\Bannerformat\UpdateRequest;

class BannerformatController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.bannerformat.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bannerformat::class);

		$bannerformats['rows'] = \App\Bannerformat::query()
			->withRelations()
			->withCount('banners')
			->sortBy(
				$bannerformats['sort'] 		= $request->sort ?? 'name',
				$bannerformats['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bannerformats'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bannerformat = \App\Bannerformat::query()
			->withRelations()
			->withCount('banners')
			->findOrFail($id)
		;

		$this->authorize('read', $bannerformat);

		$parameters['name'] = $bannerformat->name;

		// Вложенные баннеры
		if (auth()->user()->can('index', \App\Banner::class))
			$banners['rows'] = $bannerformat->banners()
				->withRelations()
				->withCount('bannerposts')
				->sortBy(
					$banners['sort']		= $request->sort ?? 'id',
					$banners['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));


		return view($this->view, compact(
			'parameters',
			'bannerformat'
		))
			->with('banners', $banners ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bannerformat = new \App\Bannerformat;

		$this->authorize('create', $bannerformat);

		return view($this->view, compact('bannerformat'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bannerformat\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$bannerformat = \App\Bannerformat::create($request->all());

		$this->authorize('create', $bannerformat);

		$bannerformat->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $bannerformat->id,
			'name'		=> $bannerformat->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BannerformatUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bannerformat = \App\Bannerformat::query()
			->findOrFail($id);

		$this->authorize('update', $bannerformat);

		$bannerformat->fill($request->all());
		$bannerformat->save();

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
		$bannerformat = \App\Bannerformat::query()
			->findOrFail($id);

		$this->authorize('read', $bannerformat);

		$parameters['name'] = $bannerformat->name;

		return view($this->view, compact(
			'parameters',
			'bannerformat'
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
		$bannerformat = \App\Bannerformat::query()
			->findOrFail($id);

		$this->authorize('delete', $bannerformat);

		$bannerformat->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bannerformat::class);

		$bannerformats = \App\Bannerformat::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bannerformats as $bannerformat)
			$answer[] = [
				'id'    => $bannerformat->id,
				'value' => $bannerformat->name,
			];

		return response()->json($answer, 200);
	}
}
