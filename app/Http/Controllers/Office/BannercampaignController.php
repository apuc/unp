<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bannercampaign\StoreRequest;
use App\Http\Requests\Office\Bannercampaign\UpdateRequest;

class BannercampaignController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.bannercampaign.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bannercampaign::class);

		$bannercampaigns['rows'] = \App\Bannercampaign::query()
			->withRelations()
			->withCount('banners')
			->sortBy(
				$bannercampaigns['sort'] 		= $request->sort ?? 'name',
				$bannercampaigns['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bannercampaigns'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bannercampaign = \App\Bannercampaign::query()
			->withRelations()
			->withCount('banners')
			->findOrFail($id)
		;

		$this->authorize('read', $bannercampaign);

		$parameters['name'] = $bannercampaign->name;

		if (auth()->user()->can('index', \App\Banner::class))
			$banners['rows'] = $bannercampaign->banners()
				->withRelations()
				->withCount('bannerposts')
				->sortBy(
					$banners['sort']		= $request->sort ?? 'name',
					$banners['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'bannercampaign'
		))
			->with('banners',	$banners ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bannercampaign = new \App\Bannercampaign;

		$this->authorize('create', $bannercampaign);

		return view($this->view, compact('bannercampaign'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bannercampaign\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$this->authorize('create', \App\Bannercampaign::class);

		$bannercampaign = \App\Bannercampaign::create($request->all());

		return response()->json([
			'status'	=> 'success',
			'id'		=> $bannercampaign->id,
			'name'		=> $bannercampaign->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BannercampaignUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bannercampaign = \App\Bannercampaign::query()
			->findOrFail($id);

		$this->authorize('update', $bannercampaign);

		$bannercampaign->fill($request->all());
		$bannercampaign->save();

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
		$bannercampaign = \App\Bannercampaign::query()
			->findOrFail($id);

		$this->authorize('read', $bannercampaign);

		$parameters['name'] = $bannercampaign->name;

		return view($this->view, compact(
			'parameters',
			'bannercampaign'
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
		$bannercampaign = \App\Bannercampaign::query()
			->findOrFail($id);

		$this->authorize('delete', $bannercampaign);

		$bannercampaign->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bannercampaign::class);

		$bannercampaigns = \App\Bannercampaign::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bannercampaigns as $bannercampaign)
			$answer[] = [
				'id'    => $bannercampaign->id,
				'value' => $bannercampaign->name,
			];

		return response()->json($answer, 200);
	}
}
