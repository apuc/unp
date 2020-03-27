<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Sitesection\StoreRequest;
use App\Http\Requests\Office\Sitesection\UpdateRequest;

class SitesectionController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.sitesection.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Sitesection::class);

		$sitesections['rows'] = \App\Sitesection::query()
			->withRelations()
			->withCount('sitetexts')
			->withCount('bannerposts')
			->sortBy(
				$sitesections['sort'] 		= $request->sort ?? 'name',
				$sitesections['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('sitesections'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$sitesection = \App\Sitesection::query()
			->withRelations()
			->withCount('sitetexts')
			->withCount('bannerposts')
			->findOrFail($id)
		;

		$this->authorize('read', $sitesection);

		$parameters['name'] = $sitesection->name;

		// Вложенные тексты сайта
		if (auth()->user()->can('index', \App\Sitetext::class))
			$sitetexts['rows'] = $sitesection->sitetexts()
				->withRelations()
				->withCount('sitepictures')
				->sortBy(
					$sitetexts['sort'] 		= $request->sort ?? 'name',
					$sitetexts['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные публикации баннеров
		if (auth()->user()->can('index', \App\Bannerpost::class))
			$bannerposts['rows'] = $sitesection->bannerposts()
				->withRelations()
				->sortBy(
					$bannerposts['sort']		= $request->sort ?? 'banner',
					$bannerposts['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'sitesection'
		))
			->with('sitetexts',		$sitetexts ?? [])
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
		$sitesection = new \App\Sitesection;

		$this->authorize('create', $sitesection);

		return view($this->view, compact('sitesection'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Sitesection\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$sitesection = \App\Sitesection::create($request->all());

		$this->authorize('create', $sitesection);

		$sitesection->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $sitesection->id,
			'name'		=> $sitesection->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\SitesectionUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$sitesection = \App\Sitesection::query()
			->findOrFail($id);

		$this->authorize('update', $sitesection);

		$sitesection->fill($request->all());
		$sitesection->save();

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
		$sitesection = \App\Sitesection::query()
			->findOrFail($id);

		$this->authorize('read', $sitesection);

		$parameters['name'] = $sitesection->name;

		return view($this->view, compact(
			'parameters',
			'sitesection'
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
		$sitesection = \App\Sitesection::query()
			->findOrFail($id);

		$this->authorize('delete', $sitesection);

		$sitesection->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Sitesection::class);

		$sitesections = \App\Sitesection::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($sitesections as $sitesection)
			$answer[] = [
				'id'    => $sitesection->id,
				'value' => $sitesection->name,
			];

		return response()->json($answer, 200);
	}
}
