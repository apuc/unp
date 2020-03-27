<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Post\StoreRequest;
use App\Http\Requests\Office\Post\UpdateRequest;

class PostController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('office.filter.post', ['only' => ['index']]);

		View::share('sidebar',      'office.post.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		\Log::info('post index');

		$this->authorize('index', \App\Post::class);

		$posts['rows'] = \App\Post::query()
			->withRelations()
			->withCount('postcomments')
			->withCount('postpictures')
			->withCount('posttags')
			->withCount('posttournaments')
			->filter()
			->sortBy(
				$posts['sort'] 			= $request->sort ?? 'posted_at',
				$posts['direction'] 	= $request->direction ?? 'desc'
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('posts'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$post = \App\Post::query()
			->withRelations()
			->withCount('postcomments')
			->withCount('postpictures')
			->withCount('posttags')
			->findOrFail($id)
		;

		$this->authorize('read', $post);

		$parameters['name'] = $post->name;

		// Вложенные комментарии
		if (auth()->user()->can('index', \App\Postcomment::class))
			$postcomments['rows'] = $post->postcomments()
				->withRelations()
				->sortBy(
					$postcomments['sort']		= $request->sort ?? 'name',
					$postcomments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные изображения
		if (auth()->user()->can('index', \App\Postpicture::class))
			$postpictures['rows'] = $post->postpictures()
				->withRelations()
				->sortBy(
					$postpictures['sort']		= $request->sort ?? 'name',
					$postpictures['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные теги
		if (auth()->user()->can('index', \App\Posttag::class))
			$posttags['rows'] = $post->posttags()
				->withRelations()
				->sortBy(
					$posttags['sort'] 		= $request->sort ?? 'name',
					$posttags['direction'] 	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные турниры
		if (auth()->user()->can('index', \App\Posttournament::class))
			$posttournaments['rows'] = $post->posttournaments()
				->withRelations()
				->sortBy(
					$posttournaments['sort'] 		= $request->sort ?? 'name',
					$posttournaments['direction'] 	= $request->direction
				)
				->paginate(config('interface.paginator'));


		return view($this->view, compact(
			'parameters',
			'post'
		))
			->with('postcomments',		$postcomments ?? [])
			->with('postpictures',		$postpictures ?? [])
			->with('posttags',			$posttags ?? [])
			->with('posttournaments',	$posttournaments ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$post = new \App\Post;

		$this->authorize('create', $post);

		$post->posted_at = now();

		return view($this->view, compact('post'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Post\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$post = \App\Post::create($request->all());

		$this->authorize('create', $post);

		\Log::info('post store user_id: ' . $post->user_id);

		$post->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $post->id,
			'name'		=> $post->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\PostUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$post = \App\Post::query()
			->findOrFail($id)
		;

		$old = clone $post;

		$this->authorize('update', $post);

		$post->fill($request->all());
		$post->save();

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
		$post = \App\Post::query()
			->findOrFail($id);

		$this->authorize('read', $post);

		$parameters['name'] = $post->name;

		return view($this->view, compact(
			'parameters',
			'post'
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
		$post = \App\Post::query()
			->findOrFail($id);

		$this->authorize('delete', $post);

		$post->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Post::class);

		$posts = \App\Post::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($posts as $post)
			$answer[] = [
				'id'    => $post->id,
				'value' => $post->name,
			];

		return response()->json($answer, 200);
	}
}
