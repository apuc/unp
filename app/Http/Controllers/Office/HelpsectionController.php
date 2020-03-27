<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Helpsection\StoreRequest;
use App\Http\Requests\Office\Helpsection\UpdateRequest;

class HelpsectionController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.helpsection.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Helpsection::class);

		$helpsections['rows'] = \App\Helpsection::query()
			->withRelations()
			->withCount('helpquestions')
			->sortBy(
				$helpsections['sort'] 		= $request->sort ?? 'name',
				$helpsections['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('helpsections'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$helpsection = \App\Helpsection::query()
			->withRelations()
			->withCount('helpquestions')
			->findOrFail($id)
		;

		$this->authorize('read', $helpsection);

		$parameters['name'] = $helpsection->name;

		// Вложенные вопросы справки
		if (auth()->user()->can('index', \App\Helpquestion::class))
			$helpquestions['rows'] = $helpsection->helpquestions()
				->withRelations()
				->withCount('helppictures')
				->sortBy(
					$helpquestions['sort'] 		= $request->sort ?? 'name',
					$helpquestions['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'helpsection'
		))
			->with('helpquestions',	$helpquestions ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$helpsection = new \App\Helpsection;

		$this->authorize('create', $helpsection);

		return view($this->view, compact('helpsection'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Helpsection\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$helpsection = \App\Helpsection::create($request->all());;

		$this->authorize('create', $helpsection);

		$helpsection->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $helpsection->id,
			'name'		=> $helpsection->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HelpsectionUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$helpsection = \App\Helpsection::query()
			->findOrFail($id);

		$this->authorize('update', $helpsection);

		$helpsection->fill($request->all());
		$helpsection->save();

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
		$helpsection = \App\Helpsection::query()
			->findOrFail($id);

		$this->authorize('read', $helpsection);

		$parameters['name'] = $helpsection->name;

		return view($this->view, compact(
			'parameters',
			'helpsection'
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
		$helpsection = \App\Helpsection::query()
			->findOrFail($id);

		$this->authorize('delete', $helpsection);

		$helpsection->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Helpsection::class);

		$helpsections = \App\Helpsection::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($helpsections as $helpsection)
			$answer[] = [
				'id'    => $helpsection->id,
				'value' => $helpsection->name,
			];

		return response()->json($answer, 200);
	}
}
