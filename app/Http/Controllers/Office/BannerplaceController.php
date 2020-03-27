<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bannerplace\StoreRequest;
use App\Http\Requests\Office\Bannerplace\UpdateRequest;

class BannerplaceController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.bannerplace.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bannerplace::class);

		$bannerplaces['rows'] = \App\Bannerplace::query()
			->withCount('bannerposts')
			->sortBy(
				$bannerplaces['sort'] 		= $request->sort ?? 'name',
				$bannerplaces['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bannerplaces'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bannerplace = \App\Bannerplace::query()
			->withCount('bannerposts')
			->findOrFail($id)
		;

		$this->authorize('read', $bannerplace);

		$parameters['name'] = $bannerplace->name;

		if (auth()->user()->can('index', \App\Bannerpost::class))
			$bannerposts['rows'] = $bannerplace->bannerposts()
				->withRelations()
				->sortBy(
					$bannerposts['sort'] 		= $request->sort ?? 'banner',
					$bannerposts['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'))
			;

		return view($this->view, compact(
			'parameters',
			'bannerplace'
		))
			->with('bannerposts', $bannerposts ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bannerplace = new \App\Bannerplace;

		$this->authorize('create', $bannerplace);

		return view($this->view, compact('bannerplace'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bannerplace\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$this->authorize('create', \App\Bannerplace::class);

		$bannerplace = \App\Bannerplace::create($request->all());

		return response()->json([
			'status'	=> 'success',
			'id'		=> $bannerplace->id,
			'name'		=> $bannerplace->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BannerplaceUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bannerplace = \App\Bannerplace::query()
			->findOrFail($id);

		$this->authorize('update', $bannerplace);

		$bannerplace->fill($request->all());
		$bannerplace->save();

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
		$bannerplace = \App\Bannerplace::query()
			->findOrFail($id);

		$this->authorize('read', $bannerplace);

		$parameters['name'] = $bannerplace->name;

		return view($this->view, compact(
			'parameters',
			'bannerplace'
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
		$bannerplace = \App\Bannerplace::query()
			->findOrFail($id);

		$this->authorize('delete', $bannerplace);

		$bannerplace->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bannerplace::class);

		$bannerplaces = \App\Bannerplace::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bannerplaces as $bannerplace)
			$answer[] = [
				'id'    => $bannerplace->id,
				'value' => $bannerplace->name,
			];

		return response()->json($answer, 200);
	}
}
