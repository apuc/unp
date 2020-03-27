<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Sport\StoreRequest;
use App\Http\Requests\Office\Sport\UpdateRequest;

class SportController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.sport.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Sport::class);

		$sports['rows'] = \App\Sport::query()
			->withRelations()
			->withCount('teams')
			->withCount('tournamenttypes')
			->withCount('tournaments')
			->withCount('posts')
			->withCount('briefs')
			->withCount('forecasts')
			->sortBy(
				$sports['sort'] 		= $request->sort ?? 'name',
				$sports['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('sports'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$sport = \App\Sport::query()
			->withRelations()
			->withCount('teams')
			->withCount('tournamenttypes')
			->withCount('tournaments')
			->withCount('posts')
			->withCount('briefs')
			->withCount('forecasts')
			->findOrFail($id)
		;

		$this->authorize('read', $sport);

		$parameters['name'] = $sport->name;

		// Вложенные команды
		if (auth()->user()->can('index', \App\Team::class))
			$teams['rows'] = $sport->teams()
				->withRelations()
				->withCount('participants')
				->sortBy(
					$teams['sort']		= $request->sort ?? 'name',
					$teams['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные типы турниров
		if (auth()->user()->can('index', \App\Tournamenttype::class))
			$tournamenttypes['rows'] = $sport->tournamenttypes()
				->withRelations()
				->withCount('tournaments')
    			->sortBy(
					$tournamenttypes['sort']		= $request->sort ?? 'name',
					$tournamenttypes['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные турниры
		if (auth()->user()->can('index', \App\Tournament::class))
			$tournaments['rows'] = $sport->tournaments()
				->withRelations()
				->withCount('seasons')
				->withCount('posttournaments as tournamentposts_count')
				->withCount('brieftournaments as tournamentbriefs_count')
				->sortBy(
					$tournaments['sort']		= $request->sort ?? 'name',
					$tournaments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные публикации
		if (auth()->user()->can('index', \App\Post::class))
			$posts['rows'] = $sport->posts()
				->withRelations()
				->withCount('postcomments')
				->withCount('postpictures')
				->sortBy(
					$posts['sort']		= $request->sort ?? 'posted_at',
					$posts['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные новости
		if (auth()->user()->can('index', \App\Brief::class))
			$briefs['rows'] = $sport->briefs()
				->withRelations()
				->withCount('briefcomments')
				->withCount('briefpictures')
				->sortBy(
					$briefs['sort']			= $request->sort ?? 'posted_at',
					$briefs['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные прогнозы
		if (auth()->user()->can('index', \App\Forecast::class))
			$forecasts['rows'] = $sport->forecasts()
				->withRelations()
				->withCount('forecastcomments')
				->withCount('forecastpictures')
				->sortBy(
					$forecasts['sort']		= $request->sort ?? 'posted_at',
					$forecasts['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'sport'
		))
			->with('teams',				$teams 			 ?? [])
			->with('tournamenttypes',	$tournamenttypes ?? [])
			->with('tournaments',		$tournaments 	 ?? [])
			->with('posts',				$posts 			 ?? [])
			->with('briefs',			$briefs 		 ?? [])
			->with('forecasts',			$forecasts 		 ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$sport = new \App\Sport;

		$this->authorize('create', $sport);

		return view($this->view, compact('sport'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Sport\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$sport = \App\Sport::create($request->all());

		$this->authorize('create', $sport);

		$sport->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $sport->id,
			'name'		=> $sport->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\SportUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$sport = \App\Sport::query()
			->findOrFail($id);

		$this->authorize('update', $sport);

		$sport->fill($request->all());
		$sport->save();

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
		$sport = \App\Sport::query()
			->findOrFail($id);

		$this->authorize('read', $sport);

		$parameters['name'] = $sport->name;

		return view($this->view, compact(
			'parameters',
			'sport'
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
		$sport = \App\Sport::query()
			->findOrFail($id);

		$this->authorize('delete', $sport);

		$sport->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Sport::class);

		$sports = \App\Sport::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($sports as $sport)
			$answer[] = [
				'id'    => $sport->id,
				'value' => $sport->name,
			];

		return response()->json($answer, 200);
	}
}
