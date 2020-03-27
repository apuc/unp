<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Offer\StoreRequest;
use App\Http\Requests\Office\Offer\UpdateRequest;

class OfferController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.offer.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Offer::class);

		$offers['rows'] = \App\Offer::query()
			->withRelations()
			->sortBy(
				$offers['sort'] 		= $request->sort ?? 'bookmaker',
				$offers['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('offers'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$offer = \App\Offer::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $offer);

		$parameters['bookmaker']	= $offer->bookmaker->name;
		$parameters['outcome']		= $offer->outcome->name;

		return view($this->view, compact(
			'parameters',
			'offer'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$offer = new \App\Offer;

		$this->authorize('create', $offer);

		return view($this->view, compact('offer'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Offer\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$offer = \App\Offer::create($request->all());;

		$this->authorize('create', $offer);

		$offer->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $offer->id,
			'name'		=> trans('option.office.offer', [
				'bookmaker'	=> $offer->bookmaker->name,
				'outcome'	=> $offer->outcome->name,
			]),
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\OfferUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$offer = \App\Offer::query()
			->findOrFail($id);

		$this->authorize('update', $offer);

		$offer->fill($request->all());
		$offer->save();

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
		$offer = \App\Offer::query()
			->findOrFail($id);

		$this->authorize('read', $offer);

		$parameters['bookmaker']	= $offer->bookmaker->name;
		$parameters['outcome']		= $offer->outcome->name;

		return view($this->view, compact(
			'parameters',
			'offer'
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
		$offer = \App\Offer::query()
			->findOrFail($id);

		$this->authorize('delete', $offer);

		$offer->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Offer::class);

		$offers = \App\Offer::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($offers as $offer)
			$answer[] = [
				'id'	=> $offer->id,
				'value'	=> trans('option.office.offer', [
					'bookmaker'	=> $offer->bookmaker->name,
					'outcome'	=> $offer->outcome->name,
				]),
			];

		return response()->json($answer, 200);
	}
}
