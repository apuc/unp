<?php

namespace App\Http\Controllers\Site;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Crumb;
use Carbon\Carbon;
use App\Http\Requests\Site\Post\StoreRequest;
use Postparameter;

class PostController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('posts')
			->first();

		// публикации
		Postparameter::boot();

		$posts['view'] = Postparameter::get('v', 0);

		$query = \App\Post::query()
			->select('posts.*')
			->with([
				'user',
				'sport',
			])
			->withCount([
				'postcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->whereHas('poststatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
		;

		Postparameter::filter($query);

		$posts['rows'] = $query->sortBy(
				$posts['sort'] = call_user_func(function () {
					switch(Postparameter::get('s')) {
						case null:
						case 0:
						default:
							return 'posted_at';

						case 1:
							return 'postcomments_count';
					}
				}),
				'desc'
			)
			->paginate($posts['rc'] = call_user_func(function () {
				switch(Postparameter::get('rc')) {
					case null:
						return config('interface.news');

					default:
						return Postparameter::get('rc');
				}
			}))
		;

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'posts'
		));
	}

	/**
	 *
	 *
	 */

	public function show($slug)
	{
		$sitesection = \App\Sitesection::query()
			->selectBySlug('posts')
			->first();

		$post = \App\Post::query()
			->select('posts.*')
			->with([
				'user',
				'sport',
				'postcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				},
				'postcomments.user',
			])
			->withCount([
				'postcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->whereHas('poststatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
			->where('id', \URI::asId($slug))
			->first();

		if (!filled($post))
			abort(404);

		Crumb::set('name',				$post->name);
		Crumb::set('seo_title',			$post->seo_title ?? $sitesection->seo_title);
		Crumb::set('seo_description',	$post->seo_description ?? trans('seo.site.post', [
			'sport'			=> $post->sport->name,
			'description'	=> $post->announce ?? $post->name,
		]));
		Crumb::set('seo_keywords',		$post->seo_keywords ?? $sitesection->seo_keywords);
		Crumb::set('og_image',			asset('/preview/512/223/storage/posts/' . $post->picture));
		Crumb::set('og_image_width',	'512');
		Crumb::set('og_image_height',	'223');

		return view($this->view, compact(
			'post'
		));
	}

	/**
	 *
	 *
	 */

	public function comment(StoreRequest $request)
	{
		$post = \App\Post::query()
			->select('posts.*')
			->whereHas('poststatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
			->where('id', \URI::asId($request->post))
			->first();

		$commentstatus = \App\Commentstatus::where('slug', 'new')->first();

		$postcomment = new \App\Postcomment;
		$postcomment->post_id			= $post->id;
		$postcomment->user_id			= Auth::user()->id;
		$postcomment->commentstatus_id	= $commentstatus->id;
		$postcomment->posted_at			= now();
		$postcomment->message			= $request->message;
		$postcomment->save();

		return redirect()->route('site.post.show', ['post' => \URI::asSlug($post->id, $post->name)]);
	}

	/**
	 *
	 *
	 *
	 */

	public function filter()
	{
		Postparameter::boot(true);

		$answer = [[
			'parameter'	=> 'count',
			'value'		=> Postparameter::get('count', 0),
		]];

		foreach (Postparameter::topical() as $param => $dataset)
			if (!is_null($dataset))
				foreach ($dataset->get('values') as $value)
					$answer[] = [
						'parameter'	=> $param,
						'value'		=> $value['value'],
					];

		return response()->json($answer, 200);
	}
}
