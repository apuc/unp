<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Outcome\StoreRequest;
use App\Http\Requests\Office\Outcome\UpdateRequest;

class OutcomeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.outcome.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Outcome::class);

		$outcomes['rows'] = \App\Outcome::query()
			->withRelations()
			->sortBy(
				$outcomes['sort'] 		= $request->sort ?? 'match',
				$outcomes['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('outcomes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$outcome = \App\Outcome::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $outcome);

		$parameters['match']			= $outcome->match->name;
		$parameters['outcometype']		= $outcome->outcometype->name;
		$parameters['outcomescope']		= $outcome->outcomescope->name;
		$parameters['outcomesubtype']	= $outcome->outcomesubtype->name;

		return view($this->view, compact(
			'parameters',
			'outcome'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$outcome = new \App\Outcome;

		$this->authorize('create', $outcome);

		return view($this->view, compact('outcome'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Outcome\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$outcome = \App\Outcome::create($request->all());;

		$this->authorize('create', $outcome);

		$outcome->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $outcome->id,
			'name'		=> trans('option.office.outcome', [
				'match'				=> $outcome->match->name,
				'outcometype'		=> $outcome->outcometype->name,
				'outcomescope'		=> $outcome->outcomescope->name,
				'outcomesubtype'	=> $outcome->outcomesubtype->name,
			]),
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\OutcomeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$outcome = \App\Outcome::query()
			->findOrFail($id);

		$this->authorize('update', $outcome);

		$outcome->fill($request->all());
		$outcome->save();

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
		$outcome = \App\Outcome::query()
			->findOrFail($id);

		$this->authorize('read', $outcome);

		$parameters['match']			= $outcome->match->name;
		$parameters['outcometype']		= $outcome->outcometype->name;
		$parameters['outcomescope']		= $outcome->outcomescope->name;
		$parameters['outcomesubtype']	= $outcome->outcomesubtype->name;

		return view($this->view, compact(
			'parameters',
			'outcome'
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
		$outcome = \App\Outcome::query()
			->findOrFail($id);

		$this->authorize('delete', $outcome);

		$outcome->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Outcome::class);

		$outcomes = \App\Outcome::query()
			->select('outcomes.*')
			->with([
				'match',
				'outcometype',
				'outcomescope',
				'outcomesubtype',
			])
			->sortBy('match', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($outcomes as $outcome)
			$answer[] = [
				'id'    => $outcome->id,
				'value'	=> trans('option.office.outcome', [
					'match'				=> $outcome->match->name,
					'outcometype'		=> $outcome->outcometype->name,
					'outcomescope'		=> $outcome->outcomescope->name,
					'outcomesubtype'	=> $outcome->outcomesubtype->name,
				]),
			];

		return response()->json($answer, 200);
	}
}
