<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bannerpost\StoreRequest;
use App\Http\Requests\Office\Bannerpost\UpdateRequest;

class BannerpostController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.bannerpost.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bannerpost::class);

		$bannerposts['rows'] = \App\Bannerpost::query()
			->withRelations()
			->sortBy(
				$bannerposts['sort'] 		= $request->sort ?? 'banner',
				$bannerposts['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bannerposts'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bannerpost = \App\Bannerpost::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $bannerpost);

		$parameters['sitesection']	= $bannerpost->sitesection->id;
		$parameters['banner']		= $bannerpost->banner->name;

		return view($this->view, compact(
			'parameters',
			'bannerpost'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bannerpost = new \App\Bannerpost;
		$bannerpost->view_amount	= 0;
		$bannerpost->click_amount	= 0;

		$this->authorize('create', $bannerpost);

		return view($this->view, compact('bannerpost'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bannerpost\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$this->authorize('create', \App\Bannerpost::class);

		$bannerpost = \App\Bannerpost::create($request->all());

		return response()->json([
			'status'	=> 'success',
			'id'		=> $bannerpost->id,
			'name'		=> trans('option.office.bannerpost', [
				'sitesection'		=> $bannerpost->sitesection->id,
				'banner'			=> $bannerpost->banner->name,
			]),
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BannerpostUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bannerpost = \App\Bannerpost::query()
			->findOrFail($id);

		$this->authorize('update', $bannerpost);

		$bannerpost->fill($request->all());
		$bannerpost->save();

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
		$bannerpost = \App\Bannerpost::query()
			->findOrFail($id);

		$this->authorize('read', $bannerpost);

		$parameters['sitesection']	= $bannerpost->sitesection->id;
		$parameters['banner']		= $bannerpost->banner->name;

		return view($this->view, compact(
			'parameters',
			'bannerpost'
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
		$bannerpost = \App\Bannerpost::query()
			->findOrFail($id);

		$this->authorize('delete', $bannerpost);

		$bannerpost->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bannerpost::class);

		$bannerposts = \App\Bannerpost::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bannerposts as $bannerpost)
			$answer[] = [
				'id'    => $bannerpost->id,
				'value' => $bannerpost->name,
			];

		return response()->json($answer, 200);
	}
}
