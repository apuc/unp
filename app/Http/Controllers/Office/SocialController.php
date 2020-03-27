<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Social\StoreRequest;
use App\Http\Requests\Office\Social\UpdateRequest;

class SocialController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.social.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Social::class);

		$socials['rows'] = \App\Social::query()
			->withRelations()
			->withCount('usersocials')
			->sortBy(
				$socials['sort'] 		= $request->sort ?? 'name',
				$socials['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('socials'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$social = \App\Social::query()
			->withRelations()
			->withCount('usersocials')
			->findOrFail($id)
		;

		$this->authorize('read', $social);

		$parameters['name'] = $social->name;

		// Вложенные соцсети пользователей
		if (auth()->user()->can('index', \App\Usersocial::class))
			$usersocials['rows'] = $social->usersocials()
				->withRelations()
				->sortBy(
					$usersocials['sort']		= $request->sort ?? 'name',
					$usersocials['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'social'
		))
			->with('usersocials',	$usersocials ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$social = new \App\Social;

		$this->authorize('create', $social);

		return view($this->view, compact('social'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Social\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$social = \App\Social::create($request->all());

		$this->authorize('create', $social);

		$social->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $social->id,
			'name'		=> $social->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\SocialUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$social = \App\Social::query()
			->findOrFail($id);

		$this->authorize('update', $social);

		$social->fill($request->all());
		$social->save();

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
		$social = \App\Social::query()
			->findOrFail($id);

		$this->authorize('read', $social);

		$parameters['name'] = $social->name;

		return view($this->view, compact(
			'parameters',
			'social'
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
		$social = \App\Social::query()
			->findOrFail($id);

		$this->authorize('delete', $social);

		$social->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Social::class);

		$socials = \App\Social::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($socials as $social)
			$answer[] = [
				'id'    => $social->id,
				'value' => $social->name,
			];

		return response()->json($answer, 200);
	}
}
