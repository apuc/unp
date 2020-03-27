<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bannersection\StoreRequest;
use App\Http\Requests\Office\Bannersection\UpdateRequest;

class BannersectionController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.bannersection.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bannersection::class);

		$bannersections['rows'] = \App\Bannersection::query()
			->withRelations()
			->withCount('bannersections')
			->withCount('bannerposts')
			->sortBy(
				$bannersections['sort'] 		= $request->sort ?? 'bannersection',
				$bannersections['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bannersections'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bannersection = \App\Bannersection::query()
			->withRelations()
			->withCount('bannersections')
			->withCount('bannerposts')
			->findOrFail($id)
		;

		$this->authorize('read', $bannersection);

		$parameters['id']			= $bannersection->id;
		$parameters['bannerplace']	= $bannersection->bannerplace->name;
		$parameters['sitesection']	= $bannersection->sitesection->name;

		if (auth()->user()->can('index', \App\Bannersection::class))
			$bannersections['rows'] = $bannersection->bannersections()
				->withRelations()
				->withCount('bannersections')
				->withCount('bannerposts')
				->sortBy(
					$bannersections['sort'] 		= $request->sort ?? 'bannersection',
					$bannersections['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'))
			;
		
		if (auth()->user()->can('index', \App\Bannerpost::class))
			$bannerposts['rows'] = $bannersection->bannerposts()
				->withRelations()
				->withCount('bannerimpressions')
				->sortBy(
					$bannerposts['sort'] 		= $request->sort ?? 'id',
					$bannerposts['direction'] 	= $request->direction
				)
				->paginate(config('interface.paginator'))
			;
		
		return view($this->view, compact(
			'parameters',
			'bannersection'
		))
			->with('bannersections',	$bannersections ?? [])
			->with('bannerposts',		$bannerposts ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bannersection = new \App\Bannersection;

		$this->authorize('create', $bannersection);

		return view($this->view, compact('bannersection'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bannersection\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$this->authorize('create', \App\Bannersection::class);

		$bannersection = \App\Bannersection::create($request->all());

		return response()->json([
			'status'	=> 'success',
			'id'		=> $bannersection->id,
			'name'		=> trans('option.office.bannersection', [
				'id'			=> $bannersection->id,
				'bannerplace'	=> $bannersection->bannerplace->name,
				'sitesection'	=> $bannersection->sitesection->name,
			]),
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BannersectionUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bannersection = \App\Bannersection::query()
			->findOrFail($id);

		$this->authorize('update', $bannersection);

		$bannersection->fill($request->all());
		$bannersection->save();

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
		$bannersection = \App\Bannersection::query()
			->findOrFail($id);

		$this->authorize('read', $bannersection);

		$parameters['id']			= $bannersection->id;
		$parameters['bannerplace']	= $bannersection->bannerplace->name;
		$parameters['sitesection']	= $bannersection->sitesection->name;

		return view($this->view, compact(
			'parameters',
			'bannersection'
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
		$bannersection = \App\Bannersection::query()
			->findOrFail($id);

		$this->authorize('delete', $bannersection);

		$bannersection->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bannersection::class);

		$bannersections = \App\Bannersection::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bannersections as $bannersection)
			$answer[] = [
				'id'    => $bannersection->id,
				'value' => trans('option.office.bannersection', [
					'id'			=> $bannersection->id,
					'bannerplace'	=> $bannersection->bannerplace->name,
					'sitesection'	=> $bannersection->sitesection->name,
				]),
			];

		return response()->json($answer, 200);
	}
}
