<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Briefcomment\StoreRequest;
use App\Http\Requests\Office\Briefcomment\UpdateRequest;

class BriefcommentController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.briefcomment.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Briefcomment::class);

		$briefcomments['rows'] = \App\Briefcomment::query()
			->withRelations()
			->sortBy(
				$briefcomments['sort'] 		= $request->sort ?? 'name',
				$briefcomments['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('briefcomments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$briefcomment = \App\Briefcomment::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $briefcomment);

		$parameters['name'] = $briefcomment->name;

		return view($this->view, compact(
			'parameters',
			'briefcomment'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$briefcomment = new \App\Briefcomment;

		$this->authorize('create', $briefcomment);

		return view($this->view, compact('briefcomment'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Briefcomment\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$briefcomment = \App\Briefcomment::create($request->all());

		$this->authorize('create', $briefcomment);

		$briefcomment->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $briefcomment->id,
			'name'		=> $briefcomment->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BriefcommentUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$briefcomment = \App\Briefcomment::query()
			->findOrFail($id)
		;

		$old = clone $briefcomment;

		$this->authorize('update', $briefcomment);

		$briefcomment->fill($request->all());
		$briefcomment->save();

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
		$briefcomment = \App\Briefcomment::query()
			->findOrFail($id);

		$this->authorize('read', $briefcomment);

		$parameters['name'] = $briefcomment->name;

		return view($this->view, compact(
			'parameters',
			'briefcomment'
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
		$briefcomment = \App\Briefcomment::query()
			->findOrFail($id);

		$this->authorize('delete', $briefcomment);

		$briefcomment->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Briefcomment::class);

		$briefcomments = \App\Briefcomment::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($briefcomments as $briefcomment)
			$answer[] = [
				'id'    => $briefcomment->id,
				'value' => $briefcomment->name,
			];

		return response()->json($answer, 200);
	}
}
