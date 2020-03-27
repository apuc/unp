<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Participant\StoreRequest;
use App\Http\Requests\Office\Participant\UpdateRequest;

class ParticipantController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.participant.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Participant::class);

		$participants['rows'] = \App\Participant::query()
			->withRelations()
			->sortBy(
				$participants['sort']		= $request->sort ?? 'name',
				$participants['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('participants'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$participant = \App\Participant::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $participant);

		$parameters['name'] = $participant->name;

		return view($this->view, compact(
			'parameters',
			'participant'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$participant = new \App\Participant;

		$this->authorize('create', $participant);

		return view($this->view, compact('participant'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Participant\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$participant = \App\Participant::create($request->all());;

		$this->authorize('create', $participant);

		$participant->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $participant->id,
			'name'		=> $participant->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\ParticipantUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$participant = \App\Participant::query()
			->findOrFail($id);

		$this->authorize('update', $participant);

		$participant->fill($request->all());
		$participant->save();

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
		$participant = \App\Participant::query()
			->findOrFail($id);

		$this->authorize('read', $participant);

		$parameters['name'] = $participant->name;

		return view($this->view, compact(
			'parameters',
			'participant'
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
		$participant = \App\Participant::query()
			->findOrFail($id);

		$this->authorize('delete', $participant);

		$participant->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Participant::class);

		$participants = \App\Participant::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($participants as $participant)
			$answer[] = [
				'id'    => $participant->id,
				'value' => $participant->name,
			];

		return response()->json($answer, 200);
	}
}
