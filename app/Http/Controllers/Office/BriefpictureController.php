<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Briefpicture\StoreRequest;
use App\Http\Requests\Office\Briefpicture\UpdateRequest;

class BriefpictureController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.briefpicture.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Briefpicture::class);

		$briefpictures['rows'] = \App\Briefpicture::query()
			->withRelations()
			->sortBy(
				$briefpictures['sort'] 		= $request->sort ?? 'name',
				$briefpictures['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('briefpictures'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$briefpicture = \App\Briefpicture::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $briefpicture);

		$parameters['name'] = $briefpicture->name;

		return view($this->view, compact(
			'parameters',
			'briefpicture'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$briefpicture = new \App\Briefpicture;

		$this->authorize('create', $briefpicture);

		return view($this->view, compact('briefpicture'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Briefpicture\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$briefpicture = \App\Briefpicture::create($request->all());;

		$this->authorize('create', $briefpicture);

		$briefpicture->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $briefpicture->id,
			'name'		=> $briefpicture->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BriefpictureUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$briefpicture = \App\Briefpicture::query()
			->findOrFail($id);

		$this->authorize('update', $briefpicture);

		$briefpicture->fill($request->all());
		$briefpicture->save();

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
		$briefpicture = \App\Briefpicture::query()
			->findOrFail($id);

		$this->authorize('read', $briefpicture);

		$parameters['name'] = $briefpicture->name;

		return view($this->view, compact(
			'parameters',
			'briefpicture'
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
		$briefpicture = \App\Briefpicture::query()
			->findOrFail($id);

		$this->authorize('delete', $briefpicture);

		$briefpicture->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Briefpicture::class);

		$briefpictures = \App\Briefpicture::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($briefpictures as $briefpicture)
			$answer[] = [
				'id'    => $briefpicture->id,
				'value' => $briefpicture->name,
			];

		return response()->json($answer, 200);
	}
}
