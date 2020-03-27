<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PreviewController extends Controller
{
	/**
	 *
	 *
	 */

	public function index($w, $h, $image)
	{
		if (!file_exists(public_path($image)) || !is_file(public_path($image)))
			$image = '/images/no_photo.jpg';

		return \Image::make(public_path($image))
			->fit($w, $h)
			->response();
	}
}
