<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Sitetext\StoreRequest;
use App\Http\Requests\Office\Sitetext\UpdateRequest;

class SitetextController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.sitetext.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Sitetext::class);

		$sitetexts['rows'] = \App\Sitetext::query()
			->withRelations()
			->withCount('sitepictures')
			->sortBy(
				$sitetexts['sort'] 		= $request->sort ?? 'name',
				$sitetexts['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('sitetexts'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$sitetext = \App\Sitetext::query()
			->withRelations()
			->withCount('sitepictures')
			->findOrFail($id)
		;

		$this->authorize('read', $sitetext);

		$parameters['name'] = $sitetext->name;

		// Вложенные изображения
		if (auth()->user()->can('index', \App\Sitetext::class))
			$sitepictures['rows'] = $sitetext->sitepictures()
				->withRelations()
				->sortBy(
					$sitepictures['sort']		= $request->sort ?? 'name',
					$sitepictures['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'sitetext'
		))
			->with('sitepictures',	$sitepictures ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$sitetext = new \App\Sitetext;

		$this->authorize('create', $sitetext);

		return view($this->view, compact('sitetext'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Sitetext\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$sitetext = \App\Sitetext::create($request->all());;

		$this->authorize('create', $sitetext);

		$sitetext->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $sitetext->id,
			'name'		=> $sitetext->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\SitetextUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$sitetext = \App\Sitetext::query()
			->findOrFail($id);

		$this->authorize('update', $sitetext);

		$sitetext->fill($request->all());
		$sitetext->save();

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
		$sitetext = \App\Sitetext::query()
			->findOrFail($id);

		$this->authorize('read', $sitetext);

		$parameters['name'] = $sitetext->name;

		return view($this->view, compact(
			'parameters',
			'sitetext'
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
		$sitetext = \App\Sitetext::query()
			->findOrFail($id);

		$this->authorize('delete', $sitetext);

		$sitetext->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Sitetext::class);

		$sitetexts = \App\Sitetext::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($sitetexts as $sitetext)
			$answer[] = [
				'id'    => $sitetext->id,
				'value' => $sitetext->name,
			];

		return response()->json($answer, 200);
	}
}
