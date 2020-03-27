<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Sitemap;
use URI;

class SitemapController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		Sitemap::generate();

		return view($this->view);
	}

	/**
	 *
	 *
	 */

	public function xml()
	{
		Sitemap::generate();

		return \Sitemap::render('xml');
	}
}
