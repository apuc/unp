<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Gender\StoreRequest;
use App\Http\Requests\Office\Gender\UpdateRequest;

class GenderController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.gender.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Gender::class);

		$genders['rows'] = \App\Gender::query()
			->withRelations()
			->withCount('tournaments')
			->withCount('stages')
			->sortBy(
				$genders['sort'] 		= $request->sort ?? 'name',
				$genders['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('genders'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$gender = \App\Gender::query()
			->withRelations()
			->withCount('tournaments')
			->withCount('stages')
			->findOrFail($id)
		;

		$this->authorize('read', $gender);

		$parameters['name'] = $gender->name;

		// Вложенные турниры
		if (auth()->user()->can('index', \App\Tournament::class))
			$tournaments['rows'] = $gender->tournaments()
				->withRelations()
				->withCount('seasons')
				->withCount('posttournaments as tournamentposts_count')
				->withCount('brieftournaments as tournamentbriefs_count')
				->sortBy(
					$tournaments['sort'] 	  = $request->sort ?? 'name',
					$tournaments['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные этапы
		if (auth()->user()->can('index', \App\Stage::class))
			$stages['rows'] = $gender->stages()
				->withRelations()
				->withCount('matches')
				->sortBy(
					$stages['sort']			= $request->sort ?? 'name',
					$stages['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'gender'
		))
			->with('tournaments',	$tournaments ?? [])
			->with('stages',		$stages		 ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$gender = new \App\Gender;

		$this->authorize('create', $gender);

		return view($this->view, compact('gender'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Gender\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$gender = \App\Gender::create($request->all());;

		$this->authorize('create', $gender);

		$gender->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $gender->id,
			'name'		=> $gender->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\GenderUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$gender = \App\Gender::query()
			->findOrFail($id);

		$this->authorize('update', $gender);

		$gender->fill($request->all());
		$gender->save();

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
		$gender = \App\Gender::query()
			->findOrFail($id);

		$this->authorize('read', $gender);

		$parameters['name'] = $gender->name;

		return view($this->view, compact(
			'parameters',
			'gender'
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
		$gender = \App\Gender::query()
			->findOrFail($id);

		$this->authorize('delete', $gender);

		$gender->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Gender::class);

		$genders = \App\Gender::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($genders as $gender)
			$answer[] = [
				'id'    => $gender->id,
				'value' => $gender->name,
			];

		return response()->json($answer, 200);
	}
}
