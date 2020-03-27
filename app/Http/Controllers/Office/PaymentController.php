<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Payment\StoreRequest;
use App\Http\Requests\Office\Payment\UpdateRequest;

class PaymentController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.payment.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Payment::class);

		$payments['rows'] = \App\Payment::query()
			->withRelations()
			->sortBy(
				$payments['sort'] 		= $request->sort ?? 'id',
				$payments['direction'] 	= $request->direction ?? 'desc'
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('payments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$payment = \App\Payment::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $payment);

		$parameters['id'] = $payment->id;

		return view($this->view, compact(
			'parameters',
			'payment'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$payment = new \App\Payment;

		$this->authorize('create', $payment);

		return view($this->view, compact('payment'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Payment\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		\Log::info($request->all());

		$payment = \App\Payment::create($request->all());

		$this->authorize('create', $payment);

		$payment->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $payment->id,
			'name'		=> $payment->id,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\PaymentUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$payment = \App\Payment::query()
			->findOrFail($id);

		$this->authorize('update', $payment);

		$payment->fill($request->all());
		$payment->save();

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
		$payment = \App\Payment::query()
			->findOrFail($id);

		$this->authorize('read', $payment);

		$parameters['name'] = $payment->name;

		return view($this->view, compact(
			'parameters',
			'payment'
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
		$payment = \App\Payment::query()
			->findOrFail($id);

		$this->authorize('delete', $payment);

		$payment->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Payment::class);

		$payments = \App\Payment::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($payments as $payment)
			$answer[] = [
				'id'    => $payment->id,
				'value' => $payment->id,
			];

		return response()->json($answer, 200);
	}
}
