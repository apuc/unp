<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Deal\StoreRequest;
use App\Http\Requests\Office\Deal\UpdateRequest;

class DealController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.deal.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Deal::class);

		$deals['rows'] = \App\Deal::query()
			->withRelations()
			->sortBy(
				$deals['sort'] 		= $request->sort ?? 'name',
				$deals['direction'] = $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('deals'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$deal = \App\Deal::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $deal);

		$parameters['name'] = $deal->name;

		return view($this->view, compact(
			'parameters',
			'deal'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$deal = new \App\Deal;

		$this->authorize('create', $deal);

		return view($this->view, compact('deal'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Deal\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$deal = \App\Deal::create($request->all());;

		$this->authorize('create', $deal);

		$deal->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $deal->id,
			'name'		=> $deal->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\Deal\UpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$deal = \App\Deal::query()
			->findOrFail($id);

		$this->authorize('update', $deal);

		$deal->fill($request->all());
		$deal->save();

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
		$deal = \App\Deal::query()
			->findOrFail($id);

		$this->authorize('read', $deal);

		$parameters['name'] = $deal->name;

		return view($this->view, compact(
			'parameters',
			'deal'
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
		$deal = \App\Deal::query()
			->findOrFail($id);

		$this->authorize('delete', $deal);

		$deal->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Deal::class);

		$deals = \App\Deal::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($deals as $deal)
			$answer[] = [
				'id'    => $deal->id,
				'value' => $deal->name,
			];

		return response()->json($answer, 200);
	}
}
