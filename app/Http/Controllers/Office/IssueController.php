<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Issue\StoreRequest;
use App\Http\Requests\Office\Issue\UpdateRequest;

class IssueController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.issue.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Issue::class);

		$issues['rows'] = \App\Issue::query()
			->withRelations()
			->withCount('answers')
			->sortBy(
				$issues['sort'] 		= $request->sort ?? 'posted_at',
				$issues['direction'] 	= $request->direction ?? 'desc'
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('issues'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$issue = \App\Issue::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $issue);

		$parameters['posted_at'] = $issue->posted_at;

		// Вложенные ответы
		if (auth()->user()->can('index', \App\Answer::class))
			$answers['rows'] = $issue->answers()
				->withRelations()
				->sortBy(
					$answers['sort']		= $request->sort ?? 'posted_at',
					$answers['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));


		return view($this->view, compact(
			'parameters',
			'issue'
		))
			->with('answers', $answers ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$issue = new \App\Issue;

		$this->authorize('create', $issue);

		return view($this->view, compact('issue'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Issue\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$issue = \App\Issue::create($request->all());;

		$this->authorize('create', $issue);

		$issue->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $issue->id,
			'posted_at'	=> $issue->posted_at,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\IssueUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$issue = \App\Issue::query()
			->findOrFail($id);

		$this->authorize('update', $issue);

		$issue->fill($request->all());
		$issue->save();

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
		$issue = \App\Issue::query()
			->findOrFail($id);

		$this->authorize('read', $issue);

		$parameters['posted_at'] = $issue->posted_at;

		return view($this->view, compact(
			'parameters',
			'issue'
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
		$issue = \App\Issue::query()
			->findOrFail($id);

		$this->authorize('delete', $issue);

		$issue->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Issue::class);

		$issues = \App\Issue::query()
			->sortBy('posted_at', 'asc')
			->filterBy('posted_at', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($issues as $issue)
			$answer[] = [
				'id'    => $issue->id,
				'value' => trans('option.office.issue', [
					'id'		=> code($issue->id),
					'posted_at'	=> $issue->posted_at,
				])
			];

		return response()->json($answer, 200);
	}
}
