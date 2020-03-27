<?php

namespace App\Http\Controllers\Office;

use Morph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\User\StoreRequest;
use App\Http\Requests\Office\User\UpdateRequest;

class UserController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('office.filter.user', ['only' => ['index']]);

		View::share('sidebar', 'office.user.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\User::class);

		$users['rows'] = \App\User::query()
			->withRelations()
			->withCount('forecasts')
			->withCount('posts')
			->withCount('postcomments')
			->withCount('briefs')
			->withCount('briefcomments')
			->withCount('forecastcomments')
			->withCount('issues')
			->withCount('answers')
			->withCount('usersocials')
			->withCount('notices')
			->withCount('events')
			->filter()
			->sortBy(
				$users['sort'] = $request->sort ?? 'login',
				$users['direction'] = $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('users'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$user = \App\User::query()
			->withRelations()
			->withCount('forecasts')
			->withCount('posts')
			->withCount('postcomments')
			->withCount('briefs')
			->withCount('briefcomments')
			->withCount('forecastcomments')
			->withCount('issues')
			->withCount('answers')
			->withCount('usersocials')
			->withCount('notices')
			->withCount('events')
			->findOrFail($id)
		;

		$this->authorize('read', $user);

		$parameters['name'] = $user->login;

		// Вложенные прогнозы
		if (auth()->user()->can('index', \App\Forecast::class))
			$forecasts['rows'] = $user->forecasts()
				->withRelations()
				->withCount('forecastcomments')
				->withCount('forecastpictures')
				->sortBy(
					$forecasts['sort']		= $request->sort ?? 'posted_at',
					$forecasts['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные публикации
		if (auth()->user()->can('index', \App\Post::class))
			$posts['rows'] = $user->posts()
				->withRelations()
				->withCount('postcomments')
				->withCount('postpictures')
				->sortBy(
					$posts['sort']		= $request->sort ?? 'posted_at',
					$posts['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные новости
		if (auth()->user()->can('index', \App\Brief::class))
			$briefs['rows'] = $user->briefs()
				->withRelations()
				->withCount('briefcomments')
				->withCount('briefpictures')
				->sortBy(
					$briefs['sort']			= $request->sort ?? 'posted_at',
					$briefs['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные комментарии к публикациям
		if (auth()->user()->can('index', \App\Postcomment::class))
			$postcomments['rows'] = $user->postcomments()
				->withRelations()
				->sortBy(
					$postcomments['sort']		= $request->sort ?? 'posted_at',
					$postcomments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные комментарии к новостям
		if (auth()->user()->can('index', \App\Briefcomment::class))
			$briefcomments['rows'] = $user->briefcomments()
				->withRelations()
				->sortBy(
					$briefcomments['sort']		= $request->sort ?? 'posted_at',
					$briefcomments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные комментарии к прогнозам
		if (auth()->user()->can('index', \App\Forecastcomment::class))
			$forecastcomments['rows'] = $user->forecastcomments()
				->withRelations()
				->sortBy(
					$forecastcomments['sort']		= $request->sort ?? 'posted_at',
					$forecastcomments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные обращения
		if (auth()->user()->can('index', \App\Issue::class))
			$issues['rows'] = $user->issues()
				->withRelations()
				->withCount('answers')
				->sortBy(
					$issues['sort']			= $request->sort ?? 'posted_at',
					$issues['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные ответы
		if (auth()->user()->can('index', \App\Answer::class))
			$answers['rows'] = $user->answers()
				->withRelations()
				->sortBy(
					$answers['sort']		= $request->sort ?? 'posted_at',
					$answers['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные соцсети пользователя
		if (auth()->user()->can('index', \App\Usersocial::class))
			$usersocials['rows'] = $user->usersocials()
				->withRelations()
				->sortBy(
					$usersocials['sort']		= $request->sort ?? 'social',
					$usersocials['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные уведомления
		if (auth()->user()->can('index', \App\Notice::class))
			$notices['rows'] = $user->notices()
				->withRelations()
				->sortBy(
					$notices['sort']		= $request->sort ?? 'posted_at',
					$notices['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные события
		if (auth()->user()->can('index', \App\Event::class))
			$events['rows'] = $user->events()
				->withRelations()
				->withCount('notices')
				->sortBy(
					$events['sort']			= $request->sort ?? 'happened_at',
					$events['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'user'
		))
			->with('forecasts',			$forecasts			?? [])
			->with('posts',				$posts				?? [])
			->with('postcomments',		$postcomments		?? [])
			->with('briefs',			$briefs				?? [])
			->with('briefcomments',		$briefcomments		?? [])
			->with('forecastcomments',	$forecastcomments	?? [])
			->with('issues',			$issues				?? [])
			->with('answers',			$answers			?? [])
			->with('usersocials',		$usersocials		?? [])
			->with('notices',			$notices			?? [])
			->with('events',			$events				?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$user = new \App\user;

		$this->authorize('create', $user);

		return view($this->view, compact('user'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\UserStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$this->authorize('create', \App\User::class);

		$request->merge([
			'visited_at'	=> now(),
			'password'		=> bcrypt($request->password),
		]);

		$user = \App\User::create($request->all());

		return response()->json([
			'status'	=> 'success',
			'id'		=> $user->id,
			'name'		=> trans('option.office.user', [
				'name'	=> $user->login,
				'email'	=> $user->email,
				'phone'	=> filled($phone = Morph::phone($user->phone, '+7 (%d%d%d) %d%d%d-%d%d-%d%d')) ? $phone : null,
			]),
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UserUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(UpdateRequest $request, $id)
	{
		$user = \App\User::query()
			->findOrFail($id);

		$this->authorize('update', $user);

		if (filled($request->password)) {
			$request->merge([
				'password' => bcrypt($request->password),
			]);

			$fields = $request->all();
		}

		else
			$fields = $request->except('password');

		$user->fill($fields);
		$user->save();

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
		$user = \App\User::query()
			->findOrFail($id);

		$this->authorize('read', $user);

		$parameters['name']		= $user->login;

		return view($this->view, compact(
			'parameters',
			'user'
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
		$user = \App\User::query()
			->findOrFail($id);

		$this->authorize('delete', $user);

		$user->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		/**
		 *
		 *
		 */

		$setAnswer = function ($user, $current) {
			return [
				'id'		=> $user->id,
				'value'		=> trans('option.office.user', [
					'name'	=> $user->login,
					'email'	=> $user->email,
					'phone'	=> filled($phone = Morph::phone($user->phone, '+7 (%d%d%d) %d%d%d-%d%d-%d%d')) ? $phone : null,
				]),
				'name'		=> $user->login,
				'email'		=> $user->email,
				'phone'		=> filled($phone = Morph::phone($user->phone, '+7 (%d%d%d) %d%d%d-%d%d-%d%d')) ? $phone : null,
				'current'	=> $current,
			];
		};

		// запрос
		$this->authorize('index', \App\User::class);

		$query = \App\User::query()
			->withRelations()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
		;

		switch($request->type) {
			case 'posts':
			case 'briefs':
				// если НЕ происходит поиск по имени
				if (null === $request->value)
					// вытаскиваем только журналистов
					$query->whereHas('role', function ($query) {
							$query->where('roles.slug', 'journalist');
						})
						->where('users.id', '<>', \Auth::user()->id)
					;

				// если происходит поиск по имени
				else
					// вытаскиваем и журналистов и текущего юзера
					$query->where(function ($query) {
						$query->whereHas('role', function ($query) {
								$query->where('roles.slug', 'journalist');
							})
							->orWhere('users.id', \Auth::user()->id)
						;
					});

				break;
		}

		$users = $query->paginate(config('interface.select'));

		// сбор ответа
		$answer = [];
		switch($request->type) {
			case 'posts':
			case 'briefs':
				// если первая страница и нет поиска по имени
				if ($request->page == 1 && null === $request->value)
					// в качестве первого юзера берем авторизованного и ставим флаг
					// current = true
					$answer[] = call_user_func($setAnswer, \Auth::user(), true);
				break;
		}

		foreach ($users as $user)
			$answer[] = call_user_func($setAnswer, $user, false);

		return response()->json($answer, 200);
	}
}
