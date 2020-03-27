<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bannerimpression\StoreRequest;
use App\Http\Requests\Office\Bannerimpression\UpdateRequest;

class BannerimpressionController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.bannerimpression.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bannerimpression::class);

		$bannerimpressions['rows'] = \App\Bannerimpression::query()
			->withRelations()
			->sortBy(
				$bannerimpressions['sort'] 		= $request->sort ?? 'impressed_at',
				$bannerimpressions['direction'] = $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bannerimpressions'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bannerimpression = \App\Bannerimpression::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $bannerimpression);

		$parameters['impressed_at'] = $bannerimpression->impressed_at;

		return view($this->view, compact(
			'parameters',
			'bannerimpression'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bannerimpression = new \App\Bannerimpression;

		$this->authorize('create', $bannerimpression);

		return view($this->view, compact('bannerimpression'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bannerimpression\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$bannerimpression = \App\Bannerimpression::create($request->all());;

		$this->authorize('create', $bannerimpression);

		$bannerimpression->save();

		return response()->json([
			'status'		=> 'success',
			'id'			=> $bannerimpression->id,
			'impressed_at'	=> $bannerimpression->impressed_at,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BannerimpressionUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bannerimpression = \App\Bannerimpression::query()
			->findOrFail($id);

		$this->authorize('update', $bannerimpression);

		$bannerimpression->fill($request->all());
		$bannerimpression->save();

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
		$bannerimpression = \App\Bannerimpression::query()
			->findOrFail($id);

		$this->authorize('read', $bannerimpression);

		$parameters['impressed_at'] = $bannerimpression->impressed_at;

		return view($this->view, compact(
			'parameters',
			'bannerimpression'
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
		$bannerimpression = \App\Bannerimpression::query()
			->findOrFail($id);

		$this->authorize('delete', $bannerimpression);

		$bannerimpression->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bannerimpression::class);

		$bannerimpressions = \App\Bannerimpression::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bannerimpressions as $bannerimpression)
			$answer[] = [
				'id'    => $bannerimpression->id,
				'value' => $bannerimpression->name,
			];

		return response()->json($answer, 200);
	}
}
