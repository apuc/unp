<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Helpquestion\StoreRequest;
use App\Http\Requests\Office\Helpquestion\UpdateRequest;

class HelpquestionController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.helpquestion.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Helpquestion::class);

		$helpquestions['rows'] = \App\Helpquestion::query()
			->withRelations()
			->withCount('helppictures')
			->sortBy(
				$helpquestions['sort'] 		= $request->sort ?? 'name',
				$helpquestions['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('helpquestions'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$helpquestion = \App\Helpquestion::query()
			->withRelations()
			->withCount('helppictures')
			->findOrFail($id)
		;

		$this->authorize('read', $helpquestion);

		$parameters['name'] = $helpquestion->name;

		// Вложенные изображения
		if (auth()->user()->can('index', \App\Helppicture::class))
			$helppictures['rows'] = $helpquestion->helppictures()
				->withRelations()
				->sortBy(
					$helppictures['sort'] 		= $request->sort ?? 'name',
					$helppictures['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'helpquestion'
		))
			->with('helppictures',	$helppictures ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$helpquestion = new \App\Helpquestion;

		$this->authorize('create', $helpquestion);

		return view($this->view, compact('helpquestion'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Helpquestion\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$helpquestion = \App\Helpquestion::create($request->all());;

		$this->authorize('create', $helpquestion);

		$helpquestion->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $helpquestion->id,
			'name'		=> $helpquestion->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HelpquestionUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$helpquestion = \App\Helpquestion::query()
			->findOrFail($id);

		$this->authorize('update', $helpquestion);

		$helpquestion->fill($request->all());
		$helpquestion->save();

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
		$helpquestion = \App\Helpquestion::query()
			->findOrFail($id);

		$this->authorize('read', $helpquestion);

		$parameters['name'] = $helpquestion->name;

		return view($this->view, compact(
			'parameters',
			'helpquestion'
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
		$helpquestion = \App\Helpquestion::query()
			->findOrFail($id);

		$this->authorize('delete', $helpquestion);

		$helpquestion->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Helpquestion::class);

		$helpquestions = \App\Helpquestion::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($helpquestions as $helpquestion)
			$answer[] = [
				'id'    => $helpquestion->id,
				'value' => $helpquestion->name,
			];

		return response()->json($answer, 200);
	}
}
