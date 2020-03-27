<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Answer\StoreRequest;
use App\Http\Requests\Office\Answer\UpdateRequest;

class AnswerController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.answer.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Answer::class);

		$answers['rows'] = \App\Answer::query()
			->withRelations()
			->sortBy(
				$answers['sort'] 		= $request->sort ?? 'posted_at',
				$answers['direction'] 	= $request->direction ?? 'desc'
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('answers'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$answer = \App\Answer::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $answer);

		$parameters['posted_at'] = $answer->posted_at;

		return view($this->view, compact(
			'parameters',
			'answer'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$answer = new \App\Answer;

		$this->authorize('create', $answer);

		return view($this->view, compact('answer'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Answer\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$answer = \App\Answer::create($request->all());;

		$this->authorize('create', $answer);

		$answer->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $answer->id,
			'posted_at'	=> $answer->posted_at,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\AnswerUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$answer = \App\Answer::query()
			->findOrFail($id);

		$this->authorize('update', $answer);

		$answer->fill($request->all());
		$answer->save();

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
		$answer = \App\Answer::query()
			->findOrFail($id);

		$this->authorize('read', $answer);

		$parameters['posted_at'] = $answer->posted_at;

		return view($this->view, compact(
			'parameters',
			'answer'
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
		$answer = \App\Answer::query()
			->findOrFail($id);

		$this->authorize('delete', $answer);

		$answer->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Answer::class);

		$answers = \App\Answer::query()
			->sortBy('posted_at', 'desc')
			->filterBy('posted_at', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($answers as $answer)
			$answer[] = [
				'id'    => $answer->id,
				'value' => $answer->posted_at,
			];

		return response()->json($answer, 200);
	}
}
